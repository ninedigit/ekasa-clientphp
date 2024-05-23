<?php

namespace NineDigit\eKasa\Client\Exceptions;

use NineDigit\eKasa\Client\Models\ProblemDetails;
use Throwable;

class ProblemDetailsException extends ApiException
{
    public ProblemDetails $details;

    public function __construct(
        ProblemDetails $details,
        $code = 0,
        Throwable $previous = null
    ) {
        $this->details = $details;
        $statusCode = $details->status;
        $message = "$details->type : $details->title";
        parent::__construct($statusCode, $message, $code, $previous);
    }

    public function __toString(): string
    {
        return __CLASS__ . ": [$this->code]: $this->message\n" .
        "Type    : {$this->details->type}\n" .
        "Title   : {$this->details->title}\n" .
        "Status  : {$this->details->status}\n" .
        "Detail  : {$this->details->detail}\n" .
        "Instance: {$this->details->instance}";
    }
}
