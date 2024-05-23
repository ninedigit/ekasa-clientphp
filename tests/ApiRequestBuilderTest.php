<?php

namespace NineDigit\eKasa\Client\Tests;

use PHPUnit\Framework\TestCase;
use NineDigit\eKasa\Client\ApiRequestBuilder;
use stdClass;

final class ApiRequestBuilderTest extends TestCase
{
    public function testBuildOfCreateGetCreatesCorrectRequest()
    {
        $path = "/resource";
        $queryString = array(
            "access_token" => "token-123"
        );
        $headers = array(
            "Accept" => "application/json"
        );

        $request = ApiRequestBuilder::createGet($path, $queryString, $headers)->build();

        $this->assertEquals("GET", $request->method);
        $this->assertEquals($path, $request->path);
        $this->assertEquals($queryString, $request->queryString);
        $this->assertEquals($headers, $request->headers);
    }

    public function testBuildOfCreatePostCreatesCorrectRequest()
    {
        $path = "/resource";
        $queryString = array(
            "access_token" => "token-123"
        );
        $headers = array(
            "Accept" => "application/json"
        );

        $request = ApiRequestBuilder::createPost($path, $queryString, $headers)->build();

        $this->assertEquals("POST", $request->method);
        $this->assertEquals($path, $request->path);
        $this->assertEquals($queryString, $request->queryString);
        $this->assertEquals($headers, $request->headers);
    }

    public function testBuildOfCreatePutCreatesCorrectRequest()
    {
        $path = "/resource";
        $queryString = array(
            "access_token" => "token-123"
        );
        $headers = array(
            "Accept" => "application/json"
        );

        $request = ApiRequestBuilder::createPut($path, $queryString, $headers)->build();

        $this->assertEquals("PUT", $request->method);
        $this->assertEquals($path, $request->path);
        $this->assertEquals($queryString, $request->queryString);
        $this->assertEquals($headers, $request->headers);
    }

    public function testBuildOfCreateDeleteCreatesCorrectRequest()
    {
        $path = "/resource";
        $queryString = array(
            "access_token" => "token-123"
        );
        $headers = array(
            "Accept" => "application/json"
        );

        $request = ApiRequestBuilder::createDelete($path, $queryString, $headers)->build();

        $this->assertEquals("DELETE", $request->method);
        $this->assertEquals($path, $request->path);
        $this->assertEquals($queryString, $request->queryString);
        $this->assertEquals($headers, $request->headers);
    }

    public function testBuildOfCreatePostWithDefaultHeadersAndPayloadCreatesCorrectRequest()
    {
        $path = "/resource";
        $queryString = array(
            "id" => "1",
            "access_token" => "token-123"
        );
        $headers = array(
            "Content-Type" => "application/json",
            "Accept" => "application/xml"
        );
        $payload = new stdClass();

        $request = ApiRequestBuilder::createPost($path, $queryString, $headers)
            ->withHeaders(array(
                "Accept" => "application/json"
            ))
            ->withQueryString(array(
                "id" => "2"
            ))
            ->withPayload($payload)
            ->build();

        $this->assertEquals("POST", $request->method);
        $this->assertEquals($path, $request->path);
        $this->assertEquals(array(
            "id" => "2",
            "access_token" => "token-123"
        ), $request->queryString);
        $this->assertEquals(array(
            "Content-Type" => "application/json",
            "Accept" => "application/json"
        ), $request->headers);
    }
}
