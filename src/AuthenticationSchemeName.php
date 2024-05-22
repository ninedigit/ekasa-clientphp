<?php

namespace NineDigit\eKasa\Client;

/**
 * Zoznam autentifikačných schém
 */
final class AuthenticationSchemeName
{
    /**
     * Základná autentifikačná schéma prihlasovacím menom a heslom
     */
    public const BASIC = "Basic";
    /**
     * Prihlásenie pomocou bezpečnostného kľúča
     */
    public const ACCESS_TOKEN = "AccessToken";

    private function __construct()
    {
    }
}
