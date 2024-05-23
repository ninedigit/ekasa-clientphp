<?php

namespace NineDigit\eKasa\Client\Models\Identities;

/**
 * Organizačná jednotka
 */
final class IdentityOrganizationUnitDto
{
    /**
     * Kód on-line registračnej pokladnice
     * Textový reťazec pozostávajúci z čísel s dĺžkou 16 alebo 17 znakov
     * @example 88812345678900001
     */
    public string $cashRegisterCode;

    /**
     * Druh pokladnice
     * @see CashRegisterType
     * @example Standard
     */
    public string $cashRegisterType;

    /**
     * Príznak, či ide o pokladnicu podnikateľa s udelenou výnimkou zo zasielania
     * údajov z ORP do systému e-kasa
     * @example false
     */
    public bool $hasRegistrationException;

    /**
     * Označenie pre nižší útvar danej organizácie v prípade jej členenia, ktorý
     * nie je samostatnou právnickou osobou
     * Neprázdny textový reťazec s maximálnou dĺžkou 1024 znakov alebo null,
     * ak nie je uvedený
     * @example Caffé Haus
     */
    public ?string $organizationUnitName;

    /**
     * Adresa predajného miesta
     */
    public ?IdentityPhysicalAddressDTO $physicalAddress;
}
