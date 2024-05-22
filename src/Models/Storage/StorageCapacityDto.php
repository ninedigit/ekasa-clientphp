<?php

namespace NineDigit\eKasa\Client\Models\Storage;

/**
 * Informácie o kapacite úložiska
 */
final class StorageCapacityDto
{
    /**
     * Celková kapacita v bajtoch
     * Nenulová hodnota
     * @example 8589934592
     */
    public int $total;

    /**
     * Využitá kapacita v bajtoch
     * Nenulová hodnota
     * @example 2173430
     */
    public int $used;
}
