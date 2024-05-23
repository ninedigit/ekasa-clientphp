<?php

namespace NineDigit\eKasa\Client;

/**
 * Abstrakcia HTTP klienta
 */
interface HttpClientInterface
{
    /**
     * Odoslanie požiadavky
     */
    public function send(ApiRequest $request): void;

    /**
     * Odoslanie požiadavky a získanie odpovede
     */
    public function receive(ApiRequest $request, $type);
}
