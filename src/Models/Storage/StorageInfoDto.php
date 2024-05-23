<?php

namespace NineDigit\eKasa\Client\Models\Storage;

/**
 * Informácie o úložisku
 */
final class StorageInfoDto
{
    /**
     * Informácie o výrobcovi úložiska
     */
    public StorageProductInfoDto $product;

    /**
     * Informácie o kapacite úložiska
     */
    public StorageCapacityDto $capacity;

    /**
     * Indikuje, či je dátové úložisko v stave iba na čítanie.
     */
    public bool $isReadOnly;
}
