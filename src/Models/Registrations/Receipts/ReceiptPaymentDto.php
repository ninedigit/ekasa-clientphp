<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

/**
 * Platidlo
 */
final class ReceiptPaymentDto
{
    /**
     * Názov platidla v dĺžke 1 až 255 znakov
     * @example Hotovosť
     * @var string
     */
    public string $name;
    /**
     * Celková suma v EUR.
     * Číslo v rozsahu -10000000 až 10000000 s presnosťou na dve desatinné miesta.
     * @example 15.00
     * @var float
     */
    public float $amount;

    public function __construct(
        float $amount,
        string $name = ReceiptPaymentName::CASH
    ) {
        $this->amount = $amount;
        $this->name = $name;
    }
}
