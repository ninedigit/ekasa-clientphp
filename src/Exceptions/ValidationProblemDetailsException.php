<?php

namespace NineDigit\eKasa\Client\Exceptions;

use NineDigit\eKasa\Client\Models\ValidationProblemDetails;
use Throwable;

final class ValidationProblemDetailsException extends ProblemDetailsException
{
    private ValidationProblemDetails $validationProblemDetails;

    public function __construct(
        ValidationProblemDetails $details,
        $code = 0,
        Throwable $previous = null
    ) {
        $this->validationProblemDetails = $details;
        parent::__construct($details, $code, $previous);
    }

    public function __toString(): string
    {
        $result = parent::__toString() . "\nErrors  :\n";

        foreach ($this->validationProblemDetails->errors as $key => $value) {
            $errors = implode(", ", $value);
            $result = $result . " - $key: $errors\n";
        }

        return $result;
    }

    public function getValidationDetails(): ValidationProblemDetails
    {
        return $this->validationProblemDetails;
    }
}
