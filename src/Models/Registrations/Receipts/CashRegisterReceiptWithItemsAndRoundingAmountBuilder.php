<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

class CashRegisterReceiptWithItemsAndRoundingAmountBuilder extends CashRegisterReceiptWithRoundingAmountBuilder
{
    protected function setItems(array $items): CashRegisterReceiptBuilder
    {
        $this->receipt->items = $items;
        return $this;
    }

    public function addItem(ReceiptItemDto ...$item)
    {
        if (!is_array($this->receipt->items)) {
            $this->receipt->items = array();
        }

        array_push($this->receipt->items, ...$item);
    }
}
