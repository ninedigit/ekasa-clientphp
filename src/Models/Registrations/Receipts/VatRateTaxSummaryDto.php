<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

/**
 * Sumár obratu pre jednu sadzbu DPH.
 */
final class VatRateTaxSummaryDto
{
    /**
     * Sadzba dane z pridanej hodnoty, alebo null pre položky nepodliehajúce DPH
     * (napr. pri predaji alebo vrátení vratných obalov).
     * @example 23.00
     * @var float|null
     */
    public ?float $vatRate = null;
    /**
     * Predstavuje celkovú sumu základu dane pre danú sadzbu DPH.
     * @example 10.00
     * @var float
     */
    public float $vatBase = 0.0;
    /**
     * Predstavuje sumu DPH pre danú sadzbu DPH.
     * @example 2.30
     * @var float
     */
    public float $vatAmount = 0.0;
    /**
     * Predstavuje celkový obrat pre danú sadzbu DPH.
     * @example 12.30
     * @var float
     */
    public float $totalAmount = 0.0;
}
