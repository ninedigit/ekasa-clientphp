<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

/**
 * Sumár obratov DPH evidovaného dokladu.
 */
final class VatRatesTaxSummaryDto
{
    /**
     * Celková suma základov dane.
     * @var float
     */
    public float $totalVatBase = 0.0;
    /**
     * Celková výška dane.
     *
     * Názov vlastnosti zámerne kopíruje preklep v názve vlastnosti na strane
     * API ("totalVatAmout"), aby sa hodnota správne deserializovala.
     * @var float
     */
    public float $totalVatAmout = 0.0;
    /**
     * Celková suma položiek podliehajúcich DPH.
     * @var float
     */
    public float $totalTaxableAmount = 0.0;
    /**
     * Celková suma položiek nepodliehajúcich DPH
     * (napríklad predaj alebo vrátenie vratných obalov).
     * @var float
     */
    public float $totalNonTaxableAmount = 0.0;
    /**
     * Celková suma položiek podliehajúcich DPH a položiek nepodliehajúcich DPH.
     * @var float
     */
    public float $totalAmount = 0.0;
    /**
     * Sumáre obratov podľa jednotlivých sadzieb DPH,
     * vrátane sumáru obratov za položky nepodliehajúce DPH.
     * @var VatRateTaxSummaryDto[]|null
     */
    public ?array $items = null;
}
