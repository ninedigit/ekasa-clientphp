<?php

namespace NineDigit\eKasa\Client\Models\Printers;

/**
 * Výsledok kontroly stavu tlačiarne.
 */
final class PrinterStatusDto{
/**
 * Stav tlačiarne
 * @see PrinterStatus
 * @example Ready
 */
public string $state;

/**
 * Stav papiera.
 * Vráti hodnotu null v prípade, ak indikácia tejto informácie nie je podporovaná použitým chráneným dátovým úložiskom.
 * @see PrinterPaperStatus
 * @example Ready
 */
public ?string $paperState;
}