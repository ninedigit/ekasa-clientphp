<?php

namespace NineDigit\eKasa\Client\Tests;

use Error;
use Exception;
use InvalidArgumentException;
use NineDigit\eKasa\Client\AccessTokenSource;
use NineDigit\eKasa\Client\ApiClientAuthenticationAccessTokenOptions;
use NineDigit\eKasa\Client\ApiClientAuthenticationOptions;
use NineDigit\eKasa\Client\Credentials;
use NineDigit\eKasa\Client\EKasaServer;
use PHPUnit\Framework\TestCase;
use NineDigit\eKasa\Client\ApiClient;
use NineDigit\eKasa\Client\ApiClientOptions;

final class ApiClientTest extends TestCase
{
    public function testCreateInstanceFromInvalidArgumentThrowsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        new ApiClient("...");
    }

    public function testCreateInstanceFromOptions()
    {
        $environment = EKasaServer::exposeDefault("test");
        $credentials = new Credentials("admin", "admin");
        $accessToken = new ApiClientAuthenticationAccessTokenOptions(
            "token-123",
            AccessTokenSource::header("X-Access-Token")
        );
        $authentication = new ApiClientAuthenticationOptions($credentials, $accessToken);
        $proxyUrl = "127.0.0.1:8888";
        $apiClientOptions = new ApiClientOptions($environment, $authentication, $proxyUrl);
        $throws = false;

        try {
            new ApiClient($apiClientOptions);
        } catch (Exception | Error $e) {
            $throws = true;
        }

        $this->assertFalse($throws);
    }
}
