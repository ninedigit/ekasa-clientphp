<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

final class RegisterReceiptRequestContextDto
{
    /**
     * Tlačové nastavenia.
     */
    public RegisterReceiptPrintContextDto $print;

    /**
     * Požiadavka evidencie dokladu.
     */
    public RegisterReceiptRequestDto $request;

    public function __construct(
        RegisterReceiptPrintContextDto $print,
        ?RegisterReceiptRequestDto $request
    ) {
        $this->print = $print;
        $this->request = $request;
    }
}
