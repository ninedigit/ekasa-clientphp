<?php

namespace NineDigit\eKasa\Client\Models\Certificates;

final class CertificateDto
{
    /**
     * Typ úložiska bezpečnostných certifikátov
     * Platná hodnota typu úložiska bezpečnostných certifikátov
     * @example PKCS12
     */
    public KeyStoreType $keyStoreType;
    /**
     * Identifikátor certifikátu
     * Textový reťazec s dĺžkou 1 a 50 znakov
     * @example 88812345678900001
     */
    public string $alias;
    /**
     * Údaje certifikátu
     * Neprázdny textový reťazec v kódovaní Base64
     */
    public string $data;
    /**
     * Heslo certifikátu, ak je nastavené
     * Heslo alebo null, ak nie je nastavené
     */
    public ?string $password;
    
}