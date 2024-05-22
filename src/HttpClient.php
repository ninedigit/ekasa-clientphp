<?php

namespace NineDigit\eKasa\Client;

use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use NineDigit\eKasa\Client\Exceptions\ApiAuthenticationException;
use NineDigit\eKasa\Client\Exceptions\ApiException;
use NineDigit\eKasa\Client\ExposeErrorCode;
use NineDigit\eKasa\Client\Exceptions\ExposeException;
use NineDigit\eKasa\Client\Exceptions\ProblemDetailsException;
use NineDigit\eKasa\Client\Serialization\SerializerInterface;
use NineDigit\eKasa\Client\Exceptions\ValidationProblemDetailsException;
use NineDigit\eKasa\Client\Models\ExposeError;
use NineDigit\eKasa\Client\Models\ProblemDetails;
use NineDigit\eKasa\Client\Models\StatusCodeProblemDetails;
use NineDigit\eKasa\Client\Models\ValidationProblemDetails;
use NineDigit\eKasa\Client\Serialization\SymfonyJsonSerializer;

class HttpClient implements HttpClientInterface
{
    private SerializerInterface $serializer;
    private array $defaultHttpHeaders;
    private array $defaultQueryString;
    private GuzzleHttpClient $client;
    private string $url;
    private bool $debug;

    public function __construct(ApiClientOptions $options)
    {
        $this->url = $options->url;
        $this->debug = $options->debug;

        $this->defaultHttpHeaders = array();
        $this->defaultQueryString = array();
        $this->serializer = $options->serializer ?? new SymfonyJsonSerializer();

        $guzzleHttpClientConfig = [
            //"base_uri" => $this->url
        ];

        if (!empty($options->proxyUrl)) {
            $guzzleHttpClientConfig["proxy"] = $options->proxyUrl;
        }

        if ($options->authentication !== null) {
            if ($options->authentication->credentials != null) {
                $guzzleHttpClientConfig["auth"] = [
                    $options->authentication->credentials->userName,
                    $options->authentication->credentials->password];
            }

            if ($options->authentication->accessToken !== null) {
                $keyName = $options->authentication->accessToken->source->keyName;
                switch ($options->authentication->accessToken->source->name) {
                    case AccessTokenSourceName::HEADER:
                        $this->defaultHttpHeaders[$keyName] = $options->authentication->accessToken->value;
                        break;
                    case AccessTokenSourceName::QUERY_STRING:
                        $this->defaultQueryString[$keyName] = $options->authentication->accessToken->value;
                        break;
                }
            }
        }

        $this->client = new GuzzleHttpClient($guzzleHttpClientConfig);
    }

    /**
     * @throws Exception
     * @throws ApiAuthenticationException
     * @throws ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     */
    public function send(ApiRequest $request): void
    {
        $requestMessage = $this->createRequestMessage($request);
        $responseMessage = $this->sendRequestMessage($requestMessage);
        $this->throwOnError($responseMessage);
    }

    /**
     * @throws GuzzleException
     * @throws ApiAuthenticationException
     * @throws ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     */
    public function receive(ApiRequest $request, $type)
    {
        $requestMessage = $this->createRequestMessage($request);
        $responseMessage = $this->sendRequestMessage($requestMessage);
        return $this->deserializeResponseMessage($responseMessage, $type);
    }

    private function createRequestMessage(ApiRequest $request): ApiRequestMessage
    {
        $body = $this->serializer->serialize($request->payload);
        $headers = array_merge($this->defaultHttpHeaders, $request->headers);
        $queryString = array_merge($this->defaultQueryString, $request->queryString);

        if (!array_key_exists(HeaderName::CONTENT_TYPE, $headers) || empty($headers[HeaderName::CONTENT_TYPE])) {
            $headers[HeaderName::CONTENT_TYPE] = MediaTypeName::APPLICATION_JSON . "; charset=utf-8";
        }

        if (!array_key_exists(HeaderName::ACCEPT, $headers) || empty($headers[HeaderName::ACCEPT])) {
            $headers[HeaderName::ACCEPT] = MediaTypeName::APPLICATION_JSON;
        }

        // https://stackoverflow.com/a/57226671/1391492

        $path = trim($request->path, "/");
        $url = rtrim($this->url, "/") . "/" . $path;

        if (count($queryString) > 0) {
            $url .= "?" . htmlspecialchars(http_build_query($queryString, "", "&", PHP_QUERY_RFC3986));
        }

        return new ApiRequestMessage($request->method, $url, $headers, $body);
    }

    /**
     * @throws GuzzleException
     */
    private function sendRequestMessage(ApiRequestMessage $request): ApiResponseMessage
    {
        $headers = array();

        try {
            $guzzleRequest = new Request(
                $request->method,
                $request->url,
                $request->headers,
                $request->body
            );
            $guzzleResponse = $this->client->send($guzzleRequest, ["debug" => $this->debug]);
            $body = $guzzleResponse->getBody();
        } catch (RequestException $ex) {
            if ($ex->hasResponse()) {
                $guzzleResponse = $ex->getResponse();
                $body = $ex->getResponse()->getBody()->getContents();
            } else {
                throw $ex;
            }
        }

        foreach ($guzzleResponse->getHeaders() as $key => $values)
            $headers[$key] = implode(', ', $values);

        $response = new ApiResponseMessage($guzzleResponse->getStatusCode(), $headers, $body);

        return $response;
    }

    /**
     * @throws Exception
     * @throws ApiAuthenticationException
     * @throws ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     */
    protected function deserializeResponseMessage(ApiResponseMessage $response, $classType)
    {
        $this->throwOnError($response);
        return $this->serializer->deserialize($response->getBody(), $classType);
    }

    /**
     * @throws Exception
     * @throws ApiAuthenticationException
     * @throws ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     */
    protected function throwOnError(ApiResponseMessage $response): void
    {
        if ($response->isSuccessStatusCode()) {
            return;
        }

        $isBeyondCodeExposeResponse = $response->getBooleanHeader(HeaderName::BEYONDCODE_EXPOSE_RESPONSE);
        $isJsonContentType = $response->hasContentType(
            MediaTypeName::APPLICATION_JSON,
            MediaTypeName::APPLICATION_PROBLEM_JSON
        );

        if ($isJsonContentType) {
            if (!$isBeyondCodeExposeResponse) {
                if ($response->hasStatusCode(400) || $response->hasStatusCode(422)) {
                    $validationProblemDetails = $this->serializer->deserialize(
                        $response->getBody(),
                        ValidationProblemDetails::class
                    );
                    throw new ValidationProblemDetailsException($validationProblemDetails);
                } elseif ($response->hasStatusCode(401)) {
                    $errorMessage = "Autentifikácia zlyhala.";
                    $schemeName = $response->getHeader(HeaderName::WWW_AUTHENTICATE);
                    switch ($schemeName) {
                        case AuthenticationSchemeName::ACCESS_TOKEN:
                            $errorMessage = "Autentifikácia zlyhala. Skontrolujte správnosť bezpečnostného kľúča.";
                            break;
                        case AuthenticationSchemeName::BASIC:
                            $errorMessage = "Autentifikácia zlyhala. Skontrolujte správnosť prihlasovacích údajov.";
                            break;
                    }
                    throw new ApiAuthenticationException($response->getStatusCode(), $schemeName, $errorMessage);
                } else {
                    $problemDetails = $this->serializer->deserialize($response->getBody(), ProblemDetails::class);
                }
            } else {
                $exposeError = $this->serializer->deserialize($response->getBody(), ExposeError::class);
                $errorMessage = $exposeError->error;

                switch ($exposeError->errorCode) {
                    case ExposeErrorCode::TUNNEL_NOT_FOUND:
                        $errorMessage = "Tunel nebol vytvorený. 
                        Cieľový počítač je vypnutý alebo nesprávne nakonfigurovaný.";
                        break;
                }

                throw new ExposeException($response->getStatusCode(), $errorMessage, $exposeError->errorCode);
            }
        } else {
            $problemDetails = new StatusCodeProblemDetails($response->getStatusCode());
        }

        throw new Exceptions\ProblemDetailsException($problemDetails);
    }
}
