<?php

namespace NineDigit\eKasa\Client;

final class Credentials
{
    public string $userName;
    public ?string $password;

    public function __construct(string $userName, ?string $password)
    {
        $this->userName = $userName;
        $this->password = $password;
    }
}
