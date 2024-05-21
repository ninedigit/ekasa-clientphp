<?php

namespace NineDigit\eKasa\Client\Models\Storage;

/**
 * Informácie o výrobcovi úložiska
 */
final class StorageProductInfoDto{
    /**
     * Názov výrobcu úložiska
     * @example Nine Digit, s.r.o.
     */
    public string $vendorName;

    /**
     * Názov úložiska
     * @example Portos eKasa CHDÚ
     */
    public string $name;

    /**
     * Verzia úložiska
     * @example v1.0
     */
    public string $version;

    /**
     * Unikátne sériové číslo úložiska
     * @example 3A21D0E474C0
     */
    public string $serialNumber;
}