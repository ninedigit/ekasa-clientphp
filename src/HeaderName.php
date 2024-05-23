<?php

namespace NineDigit\eKasa\Client;

final class HeaderName
{
    public const ACCEPT = "Accept";
    public const CONTENT_TYPE = "Content-Type";
    public const WWW_AUTHENTICATE = "WWW-Authenticate";

    // Custom
    public const BEYONDCODE_EXPOSE_RESPONSE = "BeyondCode-Expose-Response";

    private function __construct()
    {
    }
}
