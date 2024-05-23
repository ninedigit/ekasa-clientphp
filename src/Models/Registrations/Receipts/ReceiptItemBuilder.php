<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

use NineDigit\eKasa\Client\Models\QuantityDto;
use NineDigit\eKasa\Client\Models\SellerDto;

class ReceiptItemBuilder
{
    private ReceiptItemDto $receiptItem;

    protected function __construct(ReceiptItemDto $receiptItem)
    {
        $this->receiptItem = $receiptItem;
    }

    public function setSeller(?SellerDto $seller): ReceiptItemBuilder
    {
        $this->receiptItem->seller = $seller;
        return $this;
    }

    public function setSpecialRegulation(?string $taxFreeReason): ReceiptItemBuilder
    {
        $this->receiptItem->specialRegulation = $taxFreeReason;
        return $this;
    }

    public function setDescription(?string $description): ReceiptItemBuilder
    {
        $this->receiptItem->description = $description;
        return $this;
    }

    public function build(): ReceiptItemDto
    {
        return $this->receiptItem;
    }

    public static function positive(
        string $name,
        float $unitPrice,
        float $vatRate,
        QuantityDto $quantity,
        float $price
    ): ReceiptItemBuilder {
        $receiptItem = new ReceiptItemDto(
            ReceiptItemType::POSITIVE,
            $name,
            $unitPrice,
            $vatRate,
            $quantity,
            $price
        );
        return new ReceiptItemBuilder($receiptItem);
    }

    public static function returnedContainer(
        string $name,
        float $unitPrice,
        float $vatRate,
        QuantityDto $quantity,
        float $price
    ): ReceiptItemBuilder {
        $receiptItem = new ReceiptItemDto(
            ReceiptItemType::RETURNED_CONTAINER,
            $name,
            $unitPrice,
            $vatRate,
            $quantity,
            $price
        );
        return new ReceiptItemBuilder($receiptItem);
    }

    public static function returned(
        string $name,
        float $unitPrice,
        float $vatRate,
        QuantityDto $quantity,
        float $price,
        string $referenceReceiptId
    ): ReceiptItemBuilder {
        $receiptItem = new ReceiptItemDto(
            ReceiptItemType::RETURNED,
            $name,
            $unitPrice,
            $vatRate,
            $quantity,
            $price
        );
        $receiptItem->referenceReceiptId = $referenceReceiptId;
        return new ReceiptItemBuilder($receiptItem);
    }

    public static function correction(
        string $name,
        float $unitPrice,
        float $vatRate,
        QuantityDto $quantity,
        float $price,
        string $referenceReceiptId
    ): ReceiptItemBuilder {
        $receiptItem = new ReceiptItemDto(
            ReceiptItemType::CORRECTION,
            $name,
            $unitPrice,
            $vatRate,
            $quantity,
            $price
        );
        $receiptItem->referenceReceiptId = $referenceReceiptId;
        return new ReceiptItemBuilder($receiptItem);
    }

    public static function discount(
        string $name,
        float $unitPrice,
        float $vatRate,
        QuantityDto $quantity,
        float $price
    ): ReceiptItemBuilder {
        $receiptItem = new ReceiptItemDto(
            ReceiptItemType::DISCOUNT,
            $name,
            $unitPrice,
            $vatRate,
            $quantity,
            $price
        );
        return new ReceiptItemBuilder($receiptItem);
    }

    public static function advance(
        string $name,
        float $unitPrice,
        float $vatRate,
        QuantityDto $quantity,
        float $price
    ): ReceiptItemBuilder {
        $receiptItem = new ReceiptItemDto(
            ReceiptItemType::ADVANCE,
            $name,
            $unitPrice,
            $vatRate,
            $quantity,
            $price
        );
        return new ReceiptItemBuilder($receiptItem);
    }

    public static function voucher(
        string $name,
        float $unitPrice,
        float $vatRate,
        QuantityDto $quantity,
        float $price,
        string $voucherNumber
    ): ReceiptItemBuilder {
        $receiptItem = new ReceiptItemDto(
            ReceiptItemType::VOUCHER,
            $name,
            $unitPrice,
            $vatRate,
            $quantity,
            $price
        );
        $receiptItem->voucherNumber = $voucherNumber;
        return new ReceiptItemBuilder($receiptItem);
    }
}
