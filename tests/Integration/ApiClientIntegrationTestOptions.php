<?php

namespace NineDigit\eKasa\Client\Tests\Integration;

use JsonException;
use NineDigit\eKasa\Client\ApiClientOptions;

final class ApiClientIntegrationTestOptions
{
    public ApiClientOptions $apiClientOptions;

    /**
     * @throws JsonException
     */
    public static function load(string $fileName): ApiClientIntegrationTestOptions
    {
        $contents = file_get_contents($fileName);
        $data = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);

        $options = new ApiClientIntegrationTestOptions();
        $options->apiClientOptions = ApiClientOptions::load($data);

        return $options;
    }
}
