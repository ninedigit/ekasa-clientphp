<?php

namespace NineDigit\eKasa\Client\Models\Identities;

/**
 * Fyzická adresa
 */
final class IdentityPhysicalAddressDto{
    /**
     * Názov štátu
     * Neprázdny textový reťazec s maximálnou dĺžkou 255 znakov
     * @example Slovenská republika
     */
    public string $country;

    /**
     * Názov ulice. Ak obec nemá názov ulice, udáva sa tu názov obce.
     * Neprázdny textový reťazec s maximálnou dĺžkou 255 znakov
     * @example Horná
     */
    public string $streetName;

    /**
     * Názov obce. Obcou je územnosprávna jednotka charakterizovaná
     * súvislým domovým osídlením a vlastným názvom. Obcou je aj mesto.
     * Neprázdny textový reťazec s maximálnou dĺžkou 255 znakov alebo <c>null</c>, ak nie uvedený
     * @example Štrkovec
     */
    public ?string $municipality;

    /**
     * Názov budovy alebo číslo domu
     * Neprázdny textový reťazec s maximálnou dĺžkou 255 znakov alebo null, ak nie uvedený
     */
    public string $buildingNumber;

    /**
     * Súpisné číslo budovy
     * Neprázdny textový reťazec s maximálnou dĺžkou 255 znakov alebo null, ak nie uvedené
     * @example 7
     */
    public string  $propertyRegistrationNumber;

    /**
     * Doručovacia adresa
     */
    public IdentityDeliveryAddressDTO $deliveryAddress;
}