<?php

namespace NineDigit\eKasa\Client;

/**
 * Kódy chyby vrátený z API
 */
class ApiErrorCode
{
    public const UNKNOWN = 0;
    public const GENERAL_ERROR = -100;
    public const CLIENT_LOCKED = -101;
    public const INVALID_TIME = -102;
    public const INVALID_RECEIPT_NUMBER = -103;
    public const RECEIPT_NOT_FOUND = -104;
    public const IDENTITY_NOT_FOUND = -201;
    public const CERTIFICATE_ERROR = -300;
    public const CERTIFICATE_NOT_FOUND = -301;
    public const CERTIFICATE_EXPIRED = -302;
    public const STORAGE_ERROR = -400;
    public const STORAGE_INSUFFICIENT_SPACE = -401;
    public const STORAGE_DIC_MISMATCH = -402;
    public const STORAGE_DUPLICATE_KEY = -403;
    public const PRINTER_ERROR = -500;
    public const PRINTER_NOT_FOUND = -501;
    public const PRINT_RECEIPT_ERROR = -502;
    public const PRINTER_NOT_READY = -503;
    public const VALIDATION_ERROR = -900;
    public const UNAUTHENTICATED = -1000;

    private function __construct()
    {
    }
}
