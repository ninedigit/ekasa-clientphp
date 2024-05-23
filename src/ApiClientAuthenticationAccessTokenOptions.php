<?php

namespace NineDigit\eKasa\Client;

final class ApiClientAuthenticationAccessTokenOptions
{
    /**
     * Prístupový kľúč
     * @var string|null
     */
    public string $value;
    /**
     * Umiestnenie prístupového kľúča.
     * @var AccessTokenSource
     */
    public AccessTokenSource $source;

    public function __construct(string $value, ?AccessTokenSource $source = null)
    {
        $this->value = $value;

        if ($source === null) {
            $source = AccessTokenSource::header();
        }

        $this->source = $source;
    }
}
