<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

/**
 * Typ dokladu
 */
final class ReceiptType
{
    /**
     * Pokladničný doklad
     */
    public const CASH_REGISTER = "CashRegister";
    /**
     * Neplatný doklad
     */
    public const INVALID = "Invalid";
    /**
     * Paragón
     */
    public const PARAGON = "Paragon";
    /**
     * Úhrada faktúry
     */
    public const INVOICE = "Invoice";
    /**
     * Paragón pri úhrade faktúry
     */
    public const INVOICE_PARAGON = "InvoiceParagon";
    /**
     * Doklad označený slovom „Vklad“
     */
    public const DEPOSIT = "Deposit";
    /**
     * Doklad označený slovom „Výber“
     */
    public const WITHDRAW = "Withdraw";

    private function __construct()
    {
    }
}
