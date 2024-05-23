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
    public const READY = "Ready";

    /**
     * Dvierka na tlačiarni sú otvorené.
     */
    public const COVER_OPEN = "CoverOpen";

    /**
     * Nízky stav papiera v tlačiarni.
     */
    public const NEAR_END = "NearEnd";

    /**
     * Chýbajúci papier v tlačiarni.
     */
    public const EMPTY = "Empty";
}
