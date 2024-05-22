<?php

namespace NineDigit\eKasa\Client\Models\Printers;

/**
 * Stav tlačiarne
 */
final class PrinterStatus
{
    /**
     * Neznámy stav.
     */
    public const UNKNOWN = "Unknown";

    /**
     * Tlačiareň je pripravená.
     */
    public const READY = "Ready";

    /**
     * Tlačiareň nie je pripravená (zaneprázdnená alebo v chybovom stave).
     */
    public const ERROR = "Error";
}
