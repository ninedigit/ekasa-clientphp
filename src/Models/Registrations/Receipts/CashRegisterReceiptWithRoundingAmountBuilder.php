<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

class CashRegisterReceiptWithRoundingAmountBuilder extends CashRegisterReceiptBuilder
{
    public function setRoundingAmount(
        ?float $roundingAmount
    ): CashRegisterReceiptWithRoundingAmountBuilder {
        $this->receipt->roundingAmount = $roundingAmount;
        return $this;
    }
}
