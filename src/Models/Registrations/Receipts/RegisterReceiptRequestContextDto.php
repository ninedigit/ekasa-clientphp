<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

final class RegisterReceiptRequestContextDto
{
    /**
     * Tlačové nastavenia.
     */
    public RegisterReceiptPrintContextDto $print;

    /**
     * Požiadavka evidencie dokladu.
     */
    public RegisterReceiptRequestDto $request;

    public function __construct(
        RegisterReceiptPrintContextDto $print,
        ?RegisterReceiptRequestDto $request
    ) {
        $this->print = $print;
        $this->request = $request;
    }
<<<<<<< HEAD

    public static function create(
        ReceiptDto $receipt,
        RegisterReceiptPrintContextDto $printer,
        ?string $externalId = null
    ): RegisterReceiptRequestContextDto {
        $registerReceiptRequest = new RegisterReceiptRequestDto($receipt, $externalId);
        return new RegisterReceiptRequestContextDto($printer, $registerReceiptRequest);
    }
}
=======
}
>>>>>>> 582bd624e4688804b6b7b5c4d22054986873239a
