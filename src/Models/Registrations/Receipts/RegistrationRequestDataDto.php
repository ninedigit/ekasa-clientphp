<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

/*
 * Dáta požiadavky evidenie dokladu alebo polohy
 */
abstract class RegistrationRequestDataDto
{
    /**
     * Kód on-line registračnej pokladnice.
     * Textový reťazec pozostávajúci z čísel s dĺžkou 16 alebo 17 znakov.
     * @example 88812345678900001
     */
    public string $cashRegisterCode;
}
