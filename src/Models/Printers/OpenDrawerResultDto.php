<?php

namespace NineDigit\eKasa\Client\Models\Printers;

/**
 * Data related to performed drawer opening operation.
 */
final class OpenDrawerResultDto
{
    /**
     * Indicates whether print output was printed on printer.
     * @example Ready
     */
    public ?bool $opened;
}
