<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

final class RegisterReceiptResultDto extends RegisterResultDto
{
    /**
     * Dáta požiadavky evidencie
     * @var RegisterReceiptResultRequestDto
     */
    public RegisterReceiptResultRequestDto $request;
    /**
     *
     * @var RegisterReceiptResultResponseDto
     */
    public RegisterReceiptResultResponseDto $response;
}
