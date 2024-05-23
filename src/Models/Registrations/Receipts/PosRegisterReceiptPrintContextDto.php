<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

final class PosRegisterReceiptPrintContextDto extends RegisterReceiptPrintContextDto
{
    /**
     * Nastavenia tlačiarne.
     */
    public PosReceiptPrinterOptions $options;

    public function __construct(?PosReceiptPrinterOptions $options = null)
    {
        $this->options = $options ?? new PosReceiptPrinterOptions();
        parent::__construct(ReceiptPrinterName::POS);
    }
}
