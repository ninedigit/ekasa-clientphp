<?php

namespace NineDigit\eKasa\Client\Models\Registrations;

final class EKasaErrorDto
{
    /**
     * Chybová správa zo systému e-Kasa.
     * @var string
     */
    public string $message;
    /**
     * Kód chybovej správy zo systému e-Kasa.
     * @var int|null
     */
    public ?int $code;
}
