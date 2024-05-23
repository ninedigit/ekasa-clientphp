<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

use NineDigit\eKasa\Client\Models\Registrations\EKasaErrorDto;

abstract class RegisterResultDto
{
//    /**
//     * Dáta požiadavky evidencie.
//     * @var RegisterResultRequestDto
//     */
//    public RegisterResultRequestDto $request;

    /**
     * Určuje, či požiadavka zaevidovania do systému e-Kasa skončila
     * úspšene (hodnota true), neúspešne (hodnota false), alebo sa
     * požiadavku doposiaľ nepodarilo odoslať (hodnota null).
     * @var bool|null
     */
    public ?bool $isSuccessful;

//    /**
//     * Obsahuje informácie o úspešnom spracovaní požiadavky.
//     * Obsahuje hodnotu, iba ak ak $isSuccessful je true.
//     * @var RegisterResultResponseDto|null
//     */
//    public ?RegisterResultResponseDto $response;

    /**
     * Obsahuje informácie o chybe pri spracovaní požiadavky.
     * Obsahuje hodnotu, iba ak ak $isSuccessful je false.
     * @var EKasaErrorDto|null
     */
    public ?EKasaErrorDto $error;
}
