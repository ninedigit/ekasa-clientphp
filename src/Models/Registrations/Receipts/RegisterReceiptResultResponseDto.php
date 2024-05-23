<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

final class RegisterReceiptResultResponseDto extends RegisterResultResponseDto
{
    /**
     * @var ReceiptRegistrationResultReceiptDataDto
     */
    public ReceiptRegistrationResultReceiptDataDto $data;
}
