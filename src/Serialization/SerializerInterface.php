<?php

namespace NineDigit\eKasa\Client\Serialization;

interface SerializerInterface
{
    public function serialize($data): string;

    public function deserialize($data, $type);
}
