<?php

namespace NineDigit\eKasa\Client\Models\Connectivity;

/**
 * Stav internetového spojenia
 */
final class InternetConnectionState {
    /**
     * Neznámy
     */
    const UNKNOWN = "Unknown";
    /**
     * Internetové spojenie je dostupné.
     */
    const UP = "Up";
    /**
     * Internetové spojenie nie je dostupné.
     */
    const DOWN = "Down";
}