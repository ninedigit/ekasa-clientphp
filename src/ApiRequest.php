<?php

namespace NineDigit\eKasa\Client;

final class ApiRequest
{
    public string $method;
    public string $path;
    public array $headers = array();
    public array $queryString = array();
    public ?object $payload = null;

    public function __construct(
        string $method,
        string $path,
        array $queryString = array(),
        array $headers = array(),
        ?object $payload = null
    ) {
        $this->method = $method;
        $this->path = $path;
        $this->queryString = $queryString;
        $this->headers = $headers;
        $this->payload = $payload;
    }
}
