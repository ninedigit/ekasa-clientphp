<?php

namespace NineDigit\eKasa\Client\Models;

/**
 * Typ identifikátora predávajúceho, v ktorého mene bol predaný tovar alebo poskytnutá služba.
 */
final class SellerIdType
{
    /**
     * Daňové identifikačné číslo.
     */
    public const DIC = "DIC";
    /**
     * Identifikačné číslo pre daň z pridanej hodnoty.
     */
    public const ICDPH = "ICDPH";

    private function __construct()
    {
    }
}
