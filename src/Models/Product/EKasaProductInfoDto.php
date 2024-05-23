<?php

namespace NineDigit\eKasa\Client\Models\Product;

/**
 * Informácie o pokladničnom programe
 */
final class EKasaProductInfoDto
{
    /**
     * Názov výrobcu
     * @example Nine Digit, s.r.o
     */
    public string $vendorName;

    /**
     * Jedinečný identifikátor pokladničného programu.
     * @example F5838FA8195427FEC53541F044A52B6CC7BCC67A
     */
    public string $swid;

    /**
     * Informácie o pokladničnom programe eKasa klient
     */
    public ProductIdDto $ppekk;

    /**
     * Informácie o chránenom dátovom úložisku
     */
    public ProductIdDto $chdu;
}
