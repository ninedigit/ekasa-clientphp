<?php

namespace NineDigit\eKasa\Client;

final class ApiClientAuthenticationOptions
{
    /**
     * Prihlasovacie údaje pre prístup k API, ak sú nastavené.
     * @var Credentials|null
     */
    public ?Credentials $credentials;
    /**
     * Nastavenia prístupového kľúča
     * @var ApiClientAuthenticationAccessTokenOptions|null
     */
    public ?ApiClientAuthenticationAccessTokenOptions $accessToken;

    public function __construct(
        ?Credentials $credentials = null,
        ?ApiClientAuthenticationAccessTokenOptions $accessToken = null
    ) {
        $this->credentials = $credentials;
        $this->accessToken = $accessToken;
    }
}
