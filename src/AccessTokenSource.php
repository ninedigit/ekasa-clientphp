<?php

namespace NineDigit\eKasa\Client;

final class AccessTokenSource
{
    public const DEFAULT_HEADER_KEY_NAME = "x-access-token";
    public const DEFAULT_QUERY_STRING_KEY_NAME = "access_token";

    /**
     * @see AccessTokenSourceName
     * @var string
     */
    public string $name;
    public string $keyName;

    private function __construct(string $name, string $keyName)
    {
        $this->name = $name;
        $this->keyName = $keyName;
    }

    /**
     * @param string $headerName Názov hlavičky, ktorá bude obsahovať prístupový kľúč. Táto hodnota musí byť totožná
     * s tou, nastavenou v EKasa API (viďte WebAdmin -> Nastavenia -> Rozšírenia -> Expose -> Prístupový kľúč).
     * @return AccessTokenSource
     */
    public static function header(
        string $headerName = AccessTokenSource::DEFAULT_HEADER_KEY_NAME
    ): AccessTokenSource {
        return new AccessTokenSource(AccessTokenSourceName::HEADER, $headerName);
    }

    /**
     * @param string $queryStringKey Identifikátor kľúča, ktorý bude obsahovať prístupový kľúč. Táto hodnota musí byť
     * totožná s tou, nastavenou v EKasa API (viďte WebAdmin -> Nastavenia -> Rozšírenia -> Expose -> Prístupový kľúč).
     * @return AccessTokenSource
     */
    public static function queryString(
        string $queryStringKey = AccessTokenSource::DEFAULT_QUERY_STRING_KEY_NAME
    ): AccessTokenSource {
        return new AccessTokenSource(AccessTokenSourceName::QUERY_STRING, $queryStringKey);
    }
}
