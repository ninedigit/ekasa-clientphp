<?php

namespace NineDigit\eKasa\Client;

final class ApiRequestMessage
{
    public string $method;
    public string $url;
    public ?string $body = null;
    public array $headers = array();

    public function __construct(
        string $method,
        string $url,
        array $headers = array(),
        string $body = null
    ) {
        $this->method = $method;
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
    }
}
