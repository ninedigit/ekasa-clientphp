<?php

namespace NineDigit\eKasa\Client\Tests;

use PHPUnit\Framework\TestCase;
use NineDigit\eKasa\Client\ApiClientOptions;
use NineDigit\eKasa\Client\ApiResponseMessage;
use NineDigit\eKasa\Client\Exceptions\ProblemDetailsException;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptResultDto;
use NineDigit\eKasa\Client\Serialization\SymfonyJsonSerializer;
use NineDigit\eKasa\Client\Tests\TestableHttpClient;
use Throwable;

final class HttpClientTest extends TestCase
{
    public function testThrowOnErrorThrowsStatusCodeProblemDetailsForResponseWithErrorStatusCodeAndNoBody()
    {
        $apiClientOptions = new ApiClientOptions();
        $client = new TestableHttpClient($apiClientOptions);
        $response = new ApiResponseMessage(403);
        $error = null;

        try {
            $client->callThrowOnError($response);
        } catch (Throwable $e) {
            $error = $e;
        }

        $this->assertNotNull($error);
        $this->assertInstanceOf(ProblemDetailsException::class, $error);
        $this->assertEquals(403, $error->statusCode);
    }

    public function testDeserializeResponse1()
    {
        $response = json_decode(file_get_contents('data/response1.json', true), true);
        $serializer = new SymfonyJsonSerializer();
        $throws = false;

        try {
            $serializer->deserialize($response['body'], RegisterReceiptResultDto::class);
        } catch (Throwable $e) {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testDeserializeResponseMessage()
    {
        $apiClientOptions = new ApiClientOptions();
        $client = new TestableHttpClient($apiClientOptions);

        $responseStatusCode = 200;

        $responseHeaders = array(
            "Server" => "nginx/1.25.3",
            "Date" => "Tue, 28 Nov 2023 10:36:36 GMT",
            "Content-Type" => "application/json; charset=utf-8",
            "Content-Length" => "1492",
            "Connection" => "keep-alive",
            "api-supported-versions" => "1.0"
        );

        $responseBody = '{"request":{"data":{"receiptType":"CashRegister","amount":1.00,"roundingAmount":0.00,"issueDate":"2023-11-28T11:36:34+01:00","receiptNumber":8,"invoiceNumber":null,"paragonNumber":null,"icdph":"SK2120408730","ico":"50649361","customer":null,"basicVatAmount":0.17,"reducedVatAmount":null,"taxFreeAmount":null,"taxBaseBasic":0.83,"taxBaseReduced":null,"items":[{"type":"Positive","name":"TEST","price":1.00,"unitPrice":1.000000,"quantity":{"amount":1.0000,"unit":"ks"},"referenceReceiptId":null,"vatRate":20.00,"specialRegulation":null,"voucherNumber":null,"seller":null,"description":null}],"okp":"a70a8147-6abe354e-3bae2c67-87bddcfc-f34b6728","pkp":"GKxvHXuvpHFaXmifSbx4SMjKQvWS+13g6wAY6jpKOGLFPtrUDfuLEYyqI3e\/bvtg7puHExtQ0duiDE9TmxkRDNYUy6KOWUuJrteRD86dTkwT7\/2+Cr6GIOYMR9ojcoaFfbWo4iQtD40ebhWNu39fw5NyFE7hakE\/+\/bpL+PjC35Vq26QahsPYNTaZBzN\/YAN4H0yCzIcY6Y2QiCiDZOTZ6eTi5DcRbRAJfOXdQFbSKuBZHGfMaTh65YTvJaM5nAAxVM00CCl6QpeX3axpgeB3B2AvFrSdR4crkpFfvoD0qhfOh\/9cgpjCV++11Epwbl\/WBzts4Lr8fYGc1hyOtBiyQ==","payments":[{"name":"Hotovos\u0165","amount":1.00}],"headerText":"| Xtreme.sk","footerText":"\u010eakujeme za v\u00e1\u0161 n\u00e1kup.","createDate":"2023-11-28T11:36:34+01:00","dic":"2120408730","cashRegisterCode":"88821204087300001"},"id":"6c704e41-01bc-4d51-bcca-605127a117d2","externalId":"10146_353","date":"2023-11-28T11:36:34+01:00","sendingCount":1},"response":{"data":{"id":"O-E6BFE09D212F477BBFE09D212FE77BCD"},"processDate":"2023-11-28T11:36:35+01:00"},"isSuccessful":true,"error":null,"$type":"Receipt"}';
        $responseMessage = new ApiResponseMessage($responseStatusCode, $responseHeaders, $responseBody);

        $throws = false;

        try {
            $result = $client->callDeserializeResponseMessage($responseMessage, RegisterReceiptResultDto::class);
        } catch (Throwable $e) {
            $throws = true;
        }

        $this->assertFalse($throws);
    }
}
