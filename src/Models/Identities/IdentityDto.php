<?php

namespace NineDigit\eKasa\Client\Models\Identities;

/**
 * Údaje o podnikateľovi
 */
final class IdentityDto {

    /**
     * Daňové identifikačné číslo
     * Texový reťazec pozostávajúci z 10 číslic
     * @example 1234567890
     */
    public string $dic;

    /**
     * Identifikačné číslo organizácie podnikateľa, ak podnikateľovi bolo pridelené
     * Textový reťazec pozostávajúci z číslic a s dĺžkou 6, 8 alebo 12 znakov v prípadne, ak bolo IČO podnikateľovi pridelené, null v opačnom prípade
     * @example 76543210
     */
    public ?string $ico;

    /**
     * Identifikačné číslo pre daň z pridanej hodnoty, ak podnikateľ je platiteľom dane z pridanej hodnoty
     * Textový reťazec začínajúci "SK" a nasledovaný 10 číslicami v prípade,
     * ak je podnikateľ platiteľom dane z pridanej hodnoty, null ak nie je
     * @example SK1234567890
     */
    public ?string $icDph;

    /**
     * Plný názov obchodného mena podnikateľa
     * Neprázdny textový reťazec s maximálnou dĺžkou 1024 znakov
     * @example Finančná správa i.n.t.
     */
    public string $corporateBodyFullName;

    /**
     * Organizačná jednotka
     */
    public IdentityOrganizationUnitDto $organizationUnit;

    /**
     * Sídlo podnikteľa
     */
    public IdentityPhysicalAddressDto $physicalAddress;
}