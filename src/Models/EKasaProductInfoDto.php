<?php

namespace NineDigit\eKasa\Client\Models;

/**
 * Množstvo predaného tovaru alebo poskytnutej služby s príslušnou množstevnou jednotkou
 */
final class EKasaProductInfoDto
{
    /**
     * Názov výrobcu
     * @example Nine Digit, s.r.o.
     * @var string
     */
    public string $vendorName;
    /**
     * Jedinečný identifikátor pokladničného programu.
     * @example Jedinečný identifikátor pokladničného programu.
     * @var string
     */
    public string $swid;
    /**
     * Informácie o pokladničnom programe eKasa klient
     * @var ProductIdDto
     */
    public ProductIdDto $ppekk;
    /**
     * Informácie o chránenom dátovom úložisku
     * @var ProductIdDto
     */
    public ProductIdDto $chdu;
}
