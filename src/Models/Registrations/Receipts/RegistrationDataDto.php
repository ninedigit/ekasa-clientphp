<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

use DateTime;

abstract class RegistrationDataDto
{
    /**
     * Dátum a čas vytvorenia dokladu v ORP.
     * V prípade evidovania paragónu v ORP sa očakáva tento dátum neskorší
     * ako dátum vyhotovenia paragónu.
     */
    public ?DateTime $createDate;
    /**
     * Daňové identifikačné číslo.
     */
    public ?string $dic;
    /**
     * Kód on-line registračnej pokladne.
     * @example 88812345678900001
     */
    public string $cashRegisterCode;
}
