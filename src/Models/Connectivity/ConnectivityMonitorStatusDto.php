<?php

namespace NineDigit\eKasa\Client\Models\Connectivity;

/**
 * Výsledok kontroly stavu internetového pripojenia
 */
final class ConnectivityMonitorStatusDto
{
    /**
     * Čas zistenia stavu internetového pripojenia
     */
    public \DateTime $requestDate;
    /**
     * Stav internetového pripojenia
     * @example Up
     * @see InternetConnectionState
     */
    public string $state;
}
