<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

final class ReceiptRegistrationResultReceiptDataDto
{
    /**
     * Unikátny identifikátor dokladu po úspešnom zaevidovaní dokladu v systéme e-kasa,
     * ak bol doklad úspešne zaevidovaný v systéme e-kasa, inak null.
     * @var string|null
     */
    public ?string $id;
}
