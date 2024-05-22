<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

use DateTime;

class ReceiptBuilder
{
    protected ReceiptDto $receipt;

    public function __construct()
    {
        $this->receipt = new ReceiptDto();
    }

    protected function setCashRegisterCode(string $cashRegisterCode): ReceiptBuilder
    {
        $this->receipt->cashRegisterCode = $cashRegisterCode;
        return $this;
    }

    protected function setReceiptType(string $receiptType): ReceiptBuilder
    {
        $this->receipt->receiptType = $receiptType;
        return $this;
    }

    public function setHeaderText(?string $headerText): ReceiptBuilder
    {
        $this->receipt->headerText = $headerText;
        return $this;
    }

    public function setFooterText(?string $footerText): ReceiptBuilder
    {
        $this->receipt->footerText = $footerText;
        return $this;
    }

    public static function cashRegister(
        string $cashRegisterCode,
        array $items
    ): CashRegisterReceiptWithItemsAndRoundingAmountBuilder {
        $builder = new CashRegisterReceiptWithItemsAndRoundingAmountBuilder();

        $builder
            ->setItems($items)
            ->setReceiptType(ReceiptType::CASH_REGISTER)
            ->setCashRegisterCode($cashRegisterCode);

        $builder->receipt->headerText = null;
        $builder->receipt->footerText = null;
        $builder->receipt->payments = null;

        return $builder;
    }

    public static function invalid(
        string $cashRegisterCode,
        array $items
    ): CashRegisterReceiptWithItemsAndRoundingAmountBuilder {
        $builder = new CashRegisterReceiptWithItemsAndRoundingAmountBuilder();

        $builder
            ->setItems($items)
            ->setReceiptType(ReceiptType::INVALID)
            ->setCashRegisterCode($cashRegisterCode);

        $builder->receipt->headerText = null;
        $builder->receipt->footerText = null;
        $builder->receipt->payments = null;

        return $builder;
    }

    public static function paragon(
        string $cashRegisterCode,
        DateTime $issueDate,
        int $paragonNumber,
        array $items
    ): CashRegisterReceiptWithItemsAndRoundingAmountBuilder {
        $builder = new CashRegisterReceiptWithItemsAndRoundingAmountBuilder();

        $builder
            ->setItems($items)
            ->setReceiptType(ReceiptType::PARAGON)
            ->setCashRegisterCode($cashRegisterCode);

        $builder->receipt->issueDate = $issueDate;
        $builder->receipt->paragonNumber = $paragonNumber;

        $builder->receipt->headerText = null;
        $builder->receipt->footerText = null;
        $builder->receipt->payments = null;

        return $builder;
    }

    public static function invoice(
        string $cashRegisterCode,
        int $invoiceNumber,
        float $amount
    ): CashRegisterReceiptWithRoundingAmountBuilder {
        $builder = new CashRegisterReceiptWithRoundingAmountBuilder();

        $builder
            ->setReceiptType(ReceiptType::INVOICE)
            ->setCashRegisterCode($cashRegisterCode);

        $builder->receipt->amount = $amount;
        $builder->receipt->invoiceNumber = $invoiceNumber;

        $builder->receipt->headerText = null;
        $builder->receipt->footerText = null;
        $builder->receipt->payments = null;

        return $builder;
    }

    public static function invoiceParagon(
        string $cashRegisterCode,
        DateTime $issueDate,
        string $invoiceNumber,
        int $paragonNumber,
        float $amount
    ): CashRegisterReceiptWithRoundingAmountBuilder {
        $builder = new CashRegisterReceiptWithRoundingAmountBuilder();

        $builder
            ->setReceiptType(ReceiptType::INVOICE_PARAGON)
            ->setCashRegisterCode($cashRegisterCode);

        $builder->receipt->amount = $amount;
        $builder->receipt->invoiceNumber = $invoiceNumber;
        $builder->receipt->paragonNumber = $paragonNumber;
        $builder->receipt->issueDate = $issueDate;

        $builder->receipt->headerText = null;
        $builder->receipt->footerText = null;
        $builder->receipt->payments = null;

        return $builder;
    }

    public static function deposit(
        string $cashRegisterCode,
        float $amount
    ): ReceiptBuilder {
        $builder = new ReceiptBuilder();

        $builder
            ->setReceiptType(ReceiptType::DEPOSIT)
            ->setCashRegisterCode($cashRegisterCode);

        $builder->receipt->amount = $amount;

        $builder->receipt->headerText = null;
        $builder->receipt->footerText = null;

        return $builder;
    }

    public static function withdraw(
        string $cashRegisterCode,
        float $amount
    ): ReceiptBuilder {
        $builder = new ReceiptBuilder();

        $builder
            ->setReceiptType(ReceiptType::WITHDRAW)
            ->setCashRegisterCode($cashRegisterCode);

        $builder->receipt->amount = $amount;

        $builder->receipt->headerText = null;
        $builder->receipt->footerText = null;

        return $builder;
    }

    public function build(): ReceiptDto
    {
        return $this->receipt;
    }
}
