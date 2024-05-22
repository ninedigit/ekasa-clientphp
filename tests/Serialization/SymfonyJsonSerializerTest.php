<?php

namespace NineDigit\eKasa\Client\Tests\Serialization;

use PHPUnit\Framework\TestCase;
use NineDigit\eKasa\Client\Serialization\SymfonyJsonSerializer;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PosReceiptPrinterOptions;

final class SymfonyJsonSerializerTest extends TestCase
{
    public function testSerializeForEmptyPosReceiptPrinterOptions()
    {
        $serializer = new SymfonyJsonSerializer();
        $opts = new PosReceiptPrinterOptions();

        $json = $serializer->serialize($opts);

        $this->assertEquals("{}", $json);
    }

    public function testSerializeForNonEmptyPosReceiptPrinterOptions()
    {
        $serializer = new SymfonyJsonSerializer();
        $opts = new PosReceiptPrinterOptions();
        $opts->openDrawer = true;

        $json = $serializer->serialize($opts);

        $this->assertEquals("{\"openDrawer\":true}", $json);
    }
}
