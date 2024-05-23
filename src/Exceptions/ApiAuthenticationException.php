<?php

namespace NineDigit\eKasa\Client\Exceptions;

use Throwable;

class ApiAuthenticationException extends ResponseException
{
    /**
     * Názov autentifikačnej schémy, pre ktorú zlyhalo prihlásenie
     */
    public ?string $schemeName;

    public function __construct(
        ?int $statusCode = null,
        ?string $schemeName = null,
        $message = "",
        $code = 0,
        Throwable $previous = null
    ) {
        $this->schemeName = $schemeName;
        parent::__construct($statusCode, $message, $code, $previous);
    }
}
