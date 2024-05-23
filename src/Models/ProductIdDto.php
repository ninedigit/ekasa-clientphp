<?php

namespace NineDigit\eKasa\Client\Models;

final class ProductIdDto
{
    /**
     * Názov produktu
     * @example Portos eKasa
     * @var string
     */
    public string $name;
    /**
     * Verzia produktu
     * @example v1.23
     * @var string
     */
    public string $version;
}
