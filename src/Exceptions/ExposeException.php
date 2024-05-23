<?php

namespace NineDigit\eKasa\Client\Exceptions;

use NineDigit\eKasa\Client\Models\ExposeError;
use Throwable;

class ExposeException extends ResponseException
{
    public function __construct(
        ?int $statusCode = null,
        string $error = "",
        $errorCode = 0,
        Throwable $previous = null
    ) {
        parent::__construct($statusCode, $error, $errorCode, $previous);
    }

    public static function fromExposeError(
        ExposeError $exposeError,
        ?int $statusCode = null,
        Throwable $previous = null
    ): ExposeException {
        return new ExposeException(
            $statusCode,
            $exposeError->error,
            $exposeError->errorCode,
            $previous
        );
    }
}
