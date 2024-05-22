<?php

namespace NineDigit\eKasa\Client;

use InvalidArgumentException;

final class ApiRequestBuilder
{
    private ApiRequestQueryStringBuilder $queryStringBuilder;
    private ApiRequestHeadersBuilder $headersBuilder;
    private string $method;
    private string $path;
    private ?object $payload;

    public function __construct(
        string $method,
        string $path,
        array $defaultQueryString = array(),
        array $defaultHeaders = array()
    ) {
        $this->queryStringBuilder = new ApiRequestQueryStringBuilder($defaultQueryString);
        $this->headersBuilder = new ApiRequestHeadersBuilder($defaultHeaders);
        $this->method = $method;
        $this->path = $path;
        $this->payload = null;
    }

    public function withPayload(?object $payload): ApiRequestBuilder
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * Metóda na nastavenie hlavičiek
     * @param $arrayOrCallable array | callable Asociatívne pole alebo vyvolateľná
     * funkcia preberajúca ApiRequestHeadersBuilder.
     */
    public function withHeaders($arrayOrCallable): ApiRequestBuilder
    {
        if (is_callable($arrayOrCallable)) {
            $arrayOrCallable($this->headersBuilder);
        } elseif (is_array($arrayOrCallable)) {
            $this->headersBuilder->set($arrayOrCallable);
        } else {
            throw new InvalidArgumentException("Expecting array or callable as an argument.");
        }
        return $this;
    }

    /**
     * Metóda na nastavenie dopytovacieho reťazca
     * @param $arrayOrCallable array | callable Asociatívne pole alebo vyvolateľná
     * funkcia preberajúca ApiRequestQueryStringBuilder.
     */
    public function withQueryString($arrayOrCallable): ApiRequestBuilder
    {
        if (is_callable($arrayOrCallable)) {
            $arrayOrCallable($this->headersBuilder);
        } elseif (is_array($arrayOrCallable)) {
            $this->queryStringBuilder->set($arrayOrCallable);
        } else {
            throw new InvalidArgumentException("Expecting array or callable as an argument.");
        }
        return $this;
    }

    public function build(): ApiRequest
    {
        $queryString = $this->queryStringBuilder->build();
        $headers = $this->headersBuilder->build();
        return new ApiRequest($this->method, $this->path, $queryString, $headers, $this->payload);
    }

    public static function createGet(
        string $path,
        array $queryString = array(),
        array $headers = array()
    ): ApiRequestBuilder {
        return new ApiRequestBuilder(HttpMethod::GET, $path, $queryString, $headers);
    }

    public static function createPost(
        string $path,
        array $queryString = array(),
        array $headers = array()
    ): ApiRequestBuilder {
        return new ApiRequestBuilder(HttpMethod::POST, $path, $queryString, $headers);
    }

    public static function createPut(
        string $path,
        array $queryString = array(),
        array $headers = array()
    ): ApiRequestBuilder {
        return new ApiRequestBuilder(HttpMethod::PUT, $path, $queryString, $headers);
    }

    public static function createDelete(
        string $path,
        array $queryString = array(),
        array $headers = array()
    ): ApiRequestBuilder {
        return new ApiRequestBuilder(HttpMethod::DELETE, $path, $queryString, $headers);
    }
}
