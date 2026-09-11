<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

final class RegisterReceiptResultDto extends RegisterResultDto {
    /**
     * Dáta požiadavky evidencie
     * @var RegisterReceiptResultRequestDto
     */
    public RegisterReceiptResultRequestDto $request;
    /**
     * Obsahuje informácie o úspešnom spracovaní požiadavky.
     * Obsahuje hodnotu, iba ak $isSuccessful je true.
     * @var RegisterReceiptResultResponseDto|null
     */
    public ?RegisterReceiptResultResponseDto $response;
}