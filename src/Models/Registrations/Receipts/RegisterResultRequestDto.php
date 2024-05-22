<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

use DateTime;

abstract class RegisterResultRequestDto
{
    /**
     * Unikátný identifikátor požiadavky
     * @example e52ff4d1-f2ed-4493-9e9a-a73739b1ba23
     * @var string
     */
    public string $id;
    /**
     * Externý unikátny identifikátor požiadavky.
     * @var string
     */
    public string $externalId;
    /**
     * Dátum a čas odoslania požiadavky e-kasa klientom.
     * Pri opakovaných pokusoch o odoslanie môže byť neskorší,
     * ako dátum vytvorenia dátovej správy.
     * @example 2019-01-29T16:07:01+01:00
     * @var DateTime|null
     */
    public ?DateTime $date;
    /**
     * Poradové číslo pokusu o odoslanie požiadavky do systému e-Kasa.
     * @var int|null
     */
    public ?int $sendingCount;
}
