<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

final class RegisterReceiptResultRequestDto extends RegisterResultRequestDto
{
    /**
     * @var ReceiptRegistrationDataDto
     */
    public ReceiptRegistrationDataDto $data;
}
