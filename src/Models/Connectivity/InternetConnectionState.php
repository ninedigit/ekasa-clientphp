<?php

namespace NineDigit\eKasa\Client\Models\Connectivity;

/**
 * Stav internetového spojenia
 */
final class InternetConnectionState
{
    /**
     * Neznámy
     */
    public const UNKNOWN = "Unknown";
    /**
     * Internetové spojenie je dostupné.
     */
    public const UP = "Up";
    /**
     * Internetové spojenie nie je dostupné.
     */
    public const DOWN = "Down";
}
