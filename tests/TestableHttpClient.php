<?php

namespace NineDigit\eKasa\Client\Tests;

use Exception;
use NineDigit\eKasa\Client\ApiClientOptions;
use NineDigit\eKasa\Client\ApiResponseMessage;
use NineDigit\eKasa\Client\HttpClient;

final class TestableHttpClient extends HttpClient
{
    public function __construct(ApiClientOptions $options)
    {
        parent::__construct($options);
    }

    public function callThrowOnError(ApiResponseMessage $response)
    {
        return $this->throwOnError($response);
    }

    public function callDeserializeResponseMessage(ApiResponseMessage $response, $classType)
    {
        return $this->deserializeResponseMessage($response, $classType);
    }
}
