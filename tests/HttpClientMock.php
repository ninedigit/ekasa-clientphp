<?php

namespace NineDigit\eKasa\Client\Tests;

use NineDigit\eKasa\Client\ApiRequest;
use NineDigit\eKasa\Client\HttpClientInterface;

final class HttpClientMock implements HttpClientInterface
{
    private $sendCallback;
    private $receiveCallback;

    public function __construct(
        ?callable $sendCallback = null,
        ?callable $receiveCallback = null
    ) {
        $this->sendCallback = $sendCallback;
        $this->receiveCallback = $receiveCallback;
    }

    public function send(ApiRequest $request): void
    {
        if (is_callable($this->sendCallback)) {
            ($this->sendCallback)($request);
        }
    }

    public function receive(ApiRequest $request, $type)
    {
        if (is_callable($this->receiveCallback)) {
            return call_user_func($this->receiveCallback, $request, $type);
        }
    }
}
