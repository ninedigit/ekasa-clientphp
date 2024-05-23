<?php

namespace NineDigit\eKasa\Client;

final class ApiRequestQueryStringBuilder
{
    private array $queryString;

    public function __construct(array $defaultQueryString = array())
    {
        $this->queryString = $defaultQueryString;
    }

    public function set(array $queryString): ApiRequestQueryStringBuilder
    {
        foreach ($queryString as $key => $value) {
            $this->queryString[$key] = $value;
        }
        return $this;
    }

    public function clear(): void
    {
        array_splice($this->queryString, 0);
    }

    public function build(): array
    {
        return $this->queryString;
    }
}
