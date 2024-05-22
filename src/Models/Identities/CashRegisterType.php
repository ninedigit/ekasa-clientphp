<?php

namespace NineDigit\eKasa\Client\Models\Identities;

/**
 * Druh pokladnice
 */
final class CashRegisterType
{
     /**
      * Štandardná pokladnica so stálym predajným miestom
      */
    public const STANDARD = "Standard";
    /**
     * Prenosná pokladnica, používaná na rôznych predajných miestach v odlišnom čase
     */
    public const PORTABLE = "Portable";
}
