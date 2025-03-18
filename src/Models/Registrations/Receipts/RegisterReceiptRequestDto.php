<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

final class RegisterReceiptRequestDto {
    /**
     * Externý unikátny identifikátor požiadavky.
     * Neprázdny reťazec s maximálnou dĺžkou 40 znakov.
     * @example e52ff4d1-f2ed-4493-9e9a-a73739b1ba17
     */
    public ?string $externalId;

    /**
     * Doklad.
     */
    public ReceiptDto $data;

    public function __construct(
        ReceiptDto $data,
        ?string $externalId = null
    ) {
        $this->data = $data;
        $this->externalId = $externalId;
    }
}