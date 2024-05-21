<?php

namespace NineDigit\eKasa\Client\Models\Printers;

/**
 * Výsledok kontroly stavu tlačiarne.
 */

 final class PrinterStatusDto{
    /**
     * Papier je vložený.
     */
    const READY = "READY";

    /**
     * Dvierka na tlačiarni sú otvorené.
     */
    const COVEROPEN = "CoverOpen";

    /**
     * Nízky stav papiera v tlačiarni.
     */
    const NEAREND = "NearEnd";

    /**
     * Chýbajúci papier v tlačiarni.
     */
    const EMPTY = "Empty";


 }