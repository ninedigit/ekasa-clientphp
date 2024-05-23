<?php

namespace NineDigit\eKasa\Client\Models\IndexTable;

/**
 * Stav tabuľky indexov
 */
final class IndexTableStatusDto
{
    /**
     * Počet blokov zahrnutých v tabuľke indexov.
     * @example 1234567890
     */
    public int $indexTableBlocksCount;

    /**
     * Počet použitých blokov úložiska.
     */
    public int $storageBlocksCount;
}
