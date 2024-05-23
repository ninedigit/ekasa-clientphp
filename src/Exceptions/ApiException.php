<?php

namespace NineDigit\eKasa\Client\Exceptions;

use Throwable;

class ApiException extends ResponseException
{
    public function __construct(
        ?int $statusCode = null,
        $message = "",
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($statusCode, $message, $code, $previous);
    }
}
