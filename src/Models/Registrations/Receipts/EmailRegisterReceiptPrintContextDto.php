<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

final class EmailRegisterReceiptPrintContextDto extends RegisterReceiptPrintContextDto
{
    /**
     * Nastavenia tlačiarne.
     */
    public EmailReceiptPrinterOptions $options;

    public function __construct(?EmailReceiptPrinterOptions $options = null)
    {
        $this->options = $options ?? new EmailReceiptPrinterOptions();
        parent::__construct(ReceiptPrinterName::EMAIL);
    }
}
