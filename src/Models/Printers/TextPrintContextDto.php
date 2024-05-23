<?php

namespace NineDigit\eKasa\Client\Models\Printers;

/**
 * Kontextuálny objekt pre tlač nefiskálneho dokladu
 */
final class TextPrintContextDto
{
    /**
     * Text na vytlačenie.
     */
    public ?string $text;

    /**
     * Voliteľný kód pokladnice.
     * Ak je uvedený, pred textom budú vytlačené identifikačné údaje
     * pre daný kód pokladnice.
     */
    public string $cashRegisterCode;
}
