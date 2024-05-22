<?php

namespace NineDigit\eKasa\Client;

/**
 * e-Kasa prostredie
 * @deprecated Táto trieda bude vo verzií 2.0.0 vymazaná. Použite triedu EKasaServer.
 */
final class EKasaEnvironment
{
    /**
     * Adresa eKasa API na lokálnom počítači
     * @deprecated Použite EKasaServer::LOCALHOST
     */
    public const LOCALHOST = "http://localhost:3010/api";

    /**
     * Získa adresu eKasa API servera zastihnuteľnú cez Expose server.
     * Táto funkcionalita vyžaduje aktiváciu danej služby. Pre viac
     * informácií navštívte https://ekasa.ninedigit.sk
     * @deprecated Použite EKasaServer::exposeDefault($subdomain)
     * @param string $subdomain
     * @return string
     */
    public static function exposePlayground(string $subdomain): string
    {
        return "https://$subdomain.expose-int.ninedigit.sk";
    }

    /**
     * Získa adresu eKasa API servera zastihnuteľnú cez Expose server.
     * Táto funkcionalita vyžaduje aktiváciu danej služby. Pre viac
     * informácií navštívte https://ekasa.ninedigit.sk
     * @deprecated Táto metóda nemá náhradu a bude odstránená
     * @param string $subdomain
     * @return string
     */
    public static function exposeProduction(string $subdomain): string
    {
        return "https://$subdomain.expose.ninedigit.sk";
    }
}
