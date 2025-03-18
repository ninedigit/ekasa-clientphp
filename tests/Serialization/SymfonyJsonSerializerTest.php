<?php

namespace NineDigit\eKasa\Client\Tests\Serialization;

use PHPUnit\Framework\TestCase;
use NineDigit\eKasa\Client\Models\QuantityDto;
use NineDigit\eKasa\Client\Serialization\SymfonyJsonSerializer;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PosReceiptPrinterOptions;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptBuilder;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestDto;

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

    public function testSerializeRegisterReceiptRequestContextDtoWithNullPrint()
    {
        $serializer = new SymfonyJsonSerializer();

        $items = array();
        $receipt = ReceiptBuilder::cashRegister("88812345678900001", $items)->build();
        $request = new RegisterReceiptRequestDto($receipt);
        $context = new RegisterReceiptRequestContextDto(null, $request);

        $json = $serializer->serialize($context);

        $this->assertEquals("{\"request\":{\"data\":{\"receiptType\":\"CashRegister\",\"items\":[],\"cashRegisterCode\":\"88812345678900001\"}}}", $json);
    }
}