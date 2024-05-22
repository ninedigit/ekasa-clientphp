<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

use DateTime;

abstract class RegisterResultResponseDto
{
    /**
     * Dátum a čas, kedy bola požiadavka úspešne spracovaná on-line
     * systémom e-Kasa.
     * @var DateTime|null
     */
    public ?DateTime $processDate;
}
