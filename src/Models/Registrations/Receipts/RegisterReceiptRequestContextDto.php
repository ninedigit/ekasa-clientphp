<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

final class RegisterReceiptRequestContextDto {
    /**
     * Tlačové nastavenia.
     * Uvedením hodnoty null bude použitá predvolená tlačiareň
     * 
     * @var RegisterReceiptPrintContextDto|null
     */
    public ?RegisterReceiptPrintContextDto $print;

    /**
     * Požiadavka evidencie dokladu.
     */
    public RegisterReceiptRequestDto $request;

    public function __construct(
        ?RegisterReceiptPrintContextDto $print,
        ?RegisterReceiptRequestDto $request
    ) {
        $this->print = $print;
        $this->request = $request;
    }

    public static function create(
        ReceiptDto $receipt,
        ?RegisterReceiptPrintContextDto $printer = null,
        ?string $externalId = null
    ): RegisterReceiptRequestContextDto {
        $registerReceiptRequest = new RegisterReceiptRequestDto($receipt, $externalId);
        return new RegisterReceiptRequestContextDto($printer, $registerReceiptRequest);
    }
}