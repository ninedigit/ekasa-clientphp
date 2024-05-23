<?php

namespace NineDigit\eKasa\Client;

use InvalidArgumentException;
use JsonException;
use NineDigit\eKasa\Client\Serialization\SerializerInterface;

final class ApiClientOptions
{
    /**
     * Url adresa e-Kasa API servera
     * @example "http://localhost:3010/api"
     * @see EKasaServer
     */
    public string $url;

    /**
     * Adresa Proxy servera
     * @example "127.0.0.1:8888"
     */
    public ?string $proxyUrl;

    /* Indikuje aktívnosť vývojárského režímu, v ktorom
     * je napr. možné vidieť záznamy vykonaných HTTP požiadaviek.
     *
     * Viďte https://docs.guzzlephp.org/en/stable/request-options.html#debug
     */
    public bool $debug = false;

    /**
     * Nastavenie autentifikácie
     * @var ApiClientAuthenticationOptions|null
     */
    public ?ApiClientAuthenticationOptions $authentication;

    /**
     * Iba na účely testovania
     */
    public ?SerializerInterface $serializer = null;

    public function __construct(
        ?string $url = EKasaServer::LOCALHOST,
        ?ApiClientAuthenticationOptions $authentication = null,
        ?string $proxyUrl = null,
        ?bool $debug = false
    ) {
        $this->url = $url;
        $this->authentication = $authentication;
        $this->proxyUrl = $proxyUrl;
        $this->debug = $debug;
    }

    /**
     * @throws JsonException
     */
    public static function load($filenameOrData): ApiClientOptions
    {
        if (is_string($filenameOrData)) {
            $contents = file_get_contents($filenameOrData);
            $data = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } elseif (is_array($filenameOrData)) {
            $data = $filenameOrData;
        } else {
            throw new InvalidArgumentException("Expecting string or array as an argument.");
        }

        $authentication = null;

        $url = $data["url"] ?? EKasaServer::LOCALHOST;
        $proxyUrl = $data["proxyUrl"] ?? null;

        $authenticationData = $data["authentication"] ?? null;

        if ($authenticationData != null) {
            $authentication = new ApiClientAuthenticationOptions();

            $credentials = null;
            $accessToken = null;

            $credentialsData = $authenticationData["credentials"] ?? null;
            if ($credentialsData != null) {
                $credentials = new Credentials($credentialsData["userName"], $credentialsData["password"] ?? null);
            }

            $accessTokenData = $authenticationData["accessToken"] ?? null;

            if ($accessTokenData != null) {
                $accessTokenSource = null;
                $accessTokenSourceData = $accessTokenData["source"] ?? null;

                if ($accessTokenSourceData != null) {
                    $name = $accessTokenSourceData["name"] ?? null;
                    if ($name != null) {
                        $keyName = $accessTokenSourceData["keyName"] ?? null;
                        switch ($name) {
                            case AccessTokenSourceName::HEADER:
                                $accessTokenSource = AccessTokenSource::header($keyName);
                                break;

                            case AccessTokenSourceName::QUERY_STRING:
                                $accessTokenSource = AccessTokenSource::queryString($keyName);
                                break;
                        }
                    }
                }

                $accessToken = new ApiClientAuthenticationAccessTokenOptions(
                    $accessTokenData["value"],
                    $accessTokenSource
                );
            }

            $authentication->credentials = $credentials;
            $authentication->accessToken = $accessToken;
        }

        $debug = $data["debug"] ?? false;

        return new ApiClientOptions($url, $authentication, $proxyUrl, boolval($debug));
    }
}
