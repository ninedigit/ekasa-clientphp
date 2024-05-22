<?php

namespace NineDigit\eKasa\Client\Models\Printers;

/**
 * Data related to performed printing operation.
 */
final class PrintResultDto
{
    /**
     * Indicates whether print output was printed on printer.
     * @example Ready
     */
    public ?bool $printed;
}
