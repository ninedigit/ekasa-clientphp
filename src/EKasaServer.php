<?php

namespace NineDigit\eKasa\Client;

final class EKasaServer
{
    public const LOCALHOST = "http://localhost:3010/api";

    private function __construct()
    {
    }

    /**
     * Získa adresu eKasa API servera zastihnuteľnú cez Expose server.
     * Táto funkcionalita vyžaduje aktiváciu danej služby. Pre viac
     * informácií navštívte https://ekasa.ninedigit.sk
     * @param string $subdomain
     * @return string
     */
    public static function exposeDefault(string $subdomain): string
    {
        return "https://$subdomain.expose.ninedigit.sk";
    }
}
