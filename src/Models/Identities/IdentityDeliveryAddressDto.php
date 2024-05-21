<?php

namespace NineDigit\eKasa\Client\Models\Identities;

/**
 * Doručovacia adresa
 */
final class IdentityDeliveryAddressDto{
    /**
     * Poštové smerové číslo - kód, ktorý ustanovili
     * poštové autority za účelom doručovania pošty.
     * Neprázdny textový reťazec s maximálnou dĺžkou 255 znakov
     * @example 98045
     */
    public string $postalCode;
}