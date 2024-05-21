<?php

namespace NineDigit\eKasa\Client\Models\Product;

/**
 *  Informácie o produkte
 */
final class ProductIdDto{
    /**
     * Názov produktu
     * @example Portos eKasa
     */
    public string $name;

    /**
     * Verzia produktu
     * @example v1.23
     */
    public string $version;
}