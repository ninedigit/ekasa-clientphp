<?php

namespace NineDigit\eKasa\Client\Models\Printers;

/**
 * Stav tlačiarne
 */
final class PrinterStatus{
    /**
     * Neznámy stav.
     */
    const UNKNOWN = "Unknown";

    /**
     * Tlačiareň je pripravená.
     */
    const READY = "Ready";

    /**
     * Tlačiareň nie je pripravená (zaneprázdnená alebo v chybovom stave).
     */
    const ERROR = "Error";
}