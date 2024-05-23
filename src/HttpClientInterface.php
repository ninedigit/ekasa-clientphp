<?php

namespace NineDigit\eKasa\Client;

/**
 * TODO
 */
interface HttpClientInterface
{
    /**
     * TODO
     */
    public function send(ApiRequest $request): void;

    /**
     * TODO
     */
    public function receive(ApiRequest $request, $type);
}
