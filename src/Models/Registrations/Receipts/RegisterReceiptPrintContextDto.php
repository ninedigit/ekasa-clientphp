<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

// NOTE: Do not remove this line. Deserialization will fail.
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;

/**
 * @DiscriminatorMap(typeProperty="name", mapping={
 *    "pos"="NineDigit\eKasa\Client\Models\Registrations\Receipts\PosRegisterReceiptPrintContextDto",
 *    "pdf"="NineDigit\eKasa\Client\Models\Registrations\Receipts\PdfRegisterReceiptPrintContextDto",
 *    "email"="NineDigit\eKasa\Client\Models\Registrations\Receipts\EmailRegisterReceiptPrintContextDto"
 * })
 */
abstract class RegisterReceiptPrintContextDto
{
    /**
     * Názov tlačiarne, na ktorej bude doklad spracovaný.
     * Dostupné možnosti: pos, pdf, email.
     * @see ReceiptPrinterName
     */
    public string $printerName;

    /**
     * Nastavenia tlačiarne.
     */
    // public ?ReceiptPrinterOptions $options;
    public function __construct(?string $printerName/*, ?ReceiptPrinterOptions $options = null*/)
    {
        $this->printerName = $printerName;
        //$this->options = $options;
    }
}
