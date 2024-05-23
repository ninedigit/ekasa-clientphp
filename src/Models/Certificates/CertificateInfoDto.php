<?php

namespace NineDigit\eKasa\Client\Models\Certificates;

/**
 * Informácie o certifikáte
 */
final class CertificateInfoDto
{
    /**
     * Identifikátor certifikátu
     * Textový reťazec s dĺžkou 1 až 50 znakov
     * @example 88812345678900001
     */
    public string $alias;
    /**
     * Kód on-line registračnej pokladnice
     * Textový reťazec pozostávajúci z čísel s dĺžkou 16 alebo 17 znakov
     * @example 88812345678900001
     */
    public string $cashRegisterCode;
    /**
     * Dátum vystavenia certifikátu
     * Textový reťazec dátumu a času v kódovaní ISO 8601
     * @example 2019-01-30T16:07:01+01:00
     */
    public \DateTime $issueDate;
    /**
     * Dátum exspirácie certifikátu
     * Textový reťazec dátumu a času v kódovaní ISO 8601
     * @example 2021-01-29T16:07:01+01:00
     */
    public \DateTime $expirationDate;
    /**
     * Sériové číslo certifikátu
     * @example 2B0A
     */
    public string $serialNumber;
    /**
     * Indikátor exspirácie certifikátu
     * @example false
     */
    public bool $isExpired;
}
