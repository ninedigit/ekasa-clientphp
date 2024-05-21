<?php

namespace NineDigit\eKasa\Client\Models\Printers;

final class OpenDrawerResultDto{
    /**
     * Indicates whether print output was printed on printer.
     * @example Ready
     */
    public ?bool $opened;
}