<?php

namespace NineDigit\eKasa\Client\Models\Printers;

/**
 * Výsledok kontroly stavu tlačiarne.
 */
final class PrinterStatusDto
{
    /**
     * Papier je vložený.
     */
    public const READY = "READY";

    /**
     * Dvierka na tlačiarni sú otvorené.
     */
    public const COVEROPEN = "CoverOpen";

    /**
     * Nízky stav papiera v tlačiarni.
     */
    public const NEAREND = "NearEnd";

    /**
     * Chýbajúci papier v tlačiarni.
     */
    public const EMPTY = "Empty";
}
