<?php

namespace NineDigit\eKasa\Client\Tests;

use NineDigit\eKasa\Client\Models\QuantityDto;
use NineDigit\eKasa\Client\Models\Registrations\EKasaErrorDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\EmailReceiptPrinterOptions;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\EmailRegisterReceiptPrintContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PdfReceiptPrinterOptions;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PdfRegisterReceiptPrintContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PosReceiptPrinterOptions;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PosRegisterReceiptPrintContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptItemDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptItemType;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptPaymentDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptPaymentName;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptRegistrationDataDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptRegistrationResultReceiptDataDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptResultDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptResultRequestDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptResultResponseDto;
use NineDigit\eKasa\Client\Models\TaxFreeReason;
use PHPUnit\Framework\TestCase;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptType;
use NineDigit\eKasa\Client\Models\SellerDto;
use NineDigit\eKasa\Client\Models\SellerIdType;
use NineDigit\eKasa\Client\ApiErrorCode;
use NineDigit\eKasa\Client\Models\ProblemDetails;
use NineDigit\eKasa\Client\Models\ValidationProblemDetails;
use NineDigit\eKasa\Client\Serialization\SymfonyJsonSerializer;

final class SymfonyJsonSerializerTest extends TestCase
{
    public function testReceiptDtoSerialization()
    {
        $serializer = new SymfonyJsonSerializer();

        $receipt = new ReceiptDto();
        $receipt->cashRegisterCode = "88812345678900001";
        $receipt->receiptType = ReceiptType::CASH_REGISTER;
        $receipt->issueDate = DateTimeHelper::createEuropeBratislava(2023, 9, 11, 18, 14, 11);
        $receipt->invoiceNumber = "201801001";
        $receipt->paragonNumber = 429;
        $receipt->amount = 3.50;
        $receipt->roundingAmount = 0.04;
        $receipt->headerText = "Nine Digit, s.r.o.";
        $receipt->footerText = "Ďakujeme za nákup!";

        $itemSeller = new SellerDto();
        $itemSeller->id = "SK1234567890";
        $itemSeller->type = SellerIdType::ICDPH;

        $receipt->items = array(
            new ReceiptItemDto(
                ReceiptItemType::POSITIVE,
                "Coca Cola 0.25l",
                1.29,
                20.00,
                new QuantityDto(2.0000, "ks"),
                2.58,
                "Akcia",
                $itemSeller,
                TaxFreeReason::USED_GOOD,
                "201801001",
                "O-7DBCDA8A56EE426DBCDA8A56EE426D1A"
            )
        );
        $receipt->payments = array(
            new ReceiptPaymentDto(3.50, ReceiptPaymentName::CASH)
        );

        $json = $serializer->serialize($receipt);
        $data = json_decode($json, true);

        $this->assertIsArray($data);

        $this->assertEquals(ReceiptType::CASH_REGISTER, $data["receiptType"]);
        $this->assertEquals("2023-09-11T18:14:11+02:00", $data["issueDate"]);
        $this->assertEquals("201801001", $data["invoiceNumber"]);
        $this->assertEquals(429, $data["paragonNumber"]);

        $this->assertIsArray($data["items"]);
        $this->assertEquals(1, count($data["items"]));

        $this->assertIsArray($data["items"][0]);
        $this->assertEquals(ReceiptItemType::POSITIVE, $data["items"][0]["type"]);
        $this->assertEquals("Coca Cola 0.25l", $data["items"][0]["name"]);
        $this->assertEquals(2.58, $data["items"][0]["price"]);
        $this->assertEquals(1.29, $data["items"][0]["unitPrice"]);

        $this->assertIsArray($data["items"][0]["quantity"]);
        $this->assertEquals(2, $data["items"][0]["quantity"]["amount"]);
        $this->assertEquals("ks", $data["items"][0]["quantity"]["unit"]);

        $this->assertEquals(20, $data["items"][0]["vatRate"]);
        $this->assertEquals("O-7DBCDA8A56EE426DBCDA8A56EE426D1A", $data["items"][0]["referenceReceiptId"]);
        $this->assertEquals("UsedGood", $data["items"][0]["specialRegulation"]);
        $this->assertEquals("201801001", $data["items"][0]["voucherNumber"]);

        $this->assertIsArray($data["items"][0]["seller"]);
        $this->assertEquals("SK1234567890", $data["items"][0]["seller"]["id"]);
        $this->assertEquals("ICDPH", $data["items"][0]["seller"]["type"]);

        $this->assertEquals("Akcia", $data["items"][0]["description"]);

        $this->assertIsArray($data["payments"]);
        $this->assertEquals(1, count($data["payments"]));

        $this->assertIsArray($data["payments"][0]);
        $this->assertEquals(ReceiptPaymentName::CASH, $data["payments"][0]["name"]);
        $this->assertEquals(3.5, $data["payments"][0]["amount"]);

        $this->assertEquals(3.5, $data["amount"]);
        $this->assertEquals(0.04, $data["roundingAmount"]);
        $this->assertEquals("Nine Digit, s.r.o.", $data["headerText"]);
        $this->assertEquals("Ďakujeme za nákup!", $data["footerText"]);
        $this->assertEquals("88812345678900001", $data["cashRegisterCode"]);
    }

    public function testRegisterReceiptRequestDtoSerialization()
    {
        $serializer = new SymfonyJsonSerializer();
        $request = new RegisterReceiptRequestDto(new ReceiptDto(), "EID-0094736");

        $json = $serializer->serialize($request);
        $data = json_decode($json, true);

        $this->assertIsArray($data);
        $this->assertIsArray($data["data"]);
        $this->assertEquals("EID-0094736", $data["externalId"]);
    }

    public function testRegisterReceiptRequestContextDtoSerialization()
    {
        $serializer = new SymfonyJsonSerializer();
        $request = new RegisterReceiptRequestContextDto(
            new PosRegisterReceiptPrintContextDto(),
            new RegisterReceiptRequestDto(new ReceiptDto())
        );

        $json = $serializer->serialize($request);
        $data = json_decode($json, true);

        $this->assertIsArray($data);
        $this->assertIsArray($data["print"]);
        $this->assertIsArray($data["request"]);
    }

    public function testPosRegisterReceiptPrintContextDtoSerialization()
    {
        $serializer = new SymfonyJsonSerializer();

        $opts = new PosReceiptPrinterOptions();
        $opts->openDrawer = true;
        $opts->printLogo = true;
        $opts->logoMemoryAddress = 2;

        $context = new PosRegisterReceiptPrintContextDto($opts);

        $json = $serializer->serialize($context);
        $data = json_decode($json, true);

        $this->assertIsArray($data);
        $this->assertEquals("pos", $data["printerName"]);
        $this->assertIsArray($data["options"]);
        $this->assertTrue($data["options"]["openDrawer"]);
        $this->assertTrue($data["options"]["printLogo"]);
        $this->assertEquals(2, $data["options"]["logoMemoryAddress"]);
    }

    public function testPdfRegisterReceiptPrintContextDtoSerialization()
    {
        $serializer = new SymfonyJsonSerializer();

        $opts = new PdfReceiptPrinterOptions();
        $context = new PdfRegisterReceiptPrintContextDto($opts);

        $json = $serializer->serialize($context);
        $data = json_decode($json, true);

        $this->assertIsArray($data);
        $this->assertEquals("pdf", $data["printerName"]);
        $this->assertIsArray($data["options"]);
    }

    public function testEmailRegisterReceiptPrintContextDtoSerialization()
    {
        $serializer = new SymfonyJsonSerializer();

        $opts = new EmailReceiptPrinterOptions();
        $opts->to = "mail@dispostable.com";
        $opts->recipientDisplayName = "John Doe";
        $opts->subject = "Your receipt";
        $opts->body = "See your attachment";

        $context = new EmailRegisterReceiptPrintContextDto($opts);

        $json = $serializer->serialize($context);
        $data = json_decode($json, true);

        $this->assertIsArray($data);
        $this->assertEquals("email", $data["printerName"]);
        $this->assertIsArray($data["options"]);
        $this->assertEquals("mail@dispostable.com", $data["options"]["to"]);
        $this->assertEquals("John Doe", $data["options"]["recipientDisplayName"]);
        $this->assertEquals("Your receipt", $data["options"]["subject"]);
        $this->assertEquals("See your attachment", $data["options"]["body"]);
    }

    public function testRegisterReceiptResultDtoDeserialization()
    {
        $serializer = new SymfonyJsonSerializer();
        $type = RegisterReceiptResultDto::class;

        $json = '{
    "request": {
        "data": {
            "receiptType": "CashRegister",
            "amount": 3.50,
            "roundingAmount": 0.02,
            "issueDate": "2023-09-11T18:14:11+02:00",
            "receiptNumber": 6,
            "invoiceNumber": "201801001",
            "paragonNumber": 429,
            "icdph": "SK1234567890",
            "ico": "76543210",
            "customer": {
                "id": "2004567890",
                "type": "ICO"
            },
            "basicVatAmount": 0.58,
            "reducedVatAmount": 0.00,
            "taxFreeAmount": 0.00,
            "taxBaseBasic": 2.90,
            "taxBaseReduced": 0.00,
            "items": [{
                "type": "Positive",
                "name": "Coca Cola 0.25l",
                "price": 2.58,
                "unitPrice": 1.29,
                "quantity": {
                    "amount": 2.0000,
                    "unit": "ks"
                },
                "referenceReceiptId": "O-7DBCDA8A56EE426DBCDA8A56EE426D1A",
                "vatRate": 20.00,
                "specialRegulation": "UsedGood",
                "voucherNumber": "201801001",
                "seller": {
                    "id": "SK1234567890",
                    "type": "ICDPH"
                },
                "description": "Tovar"
            }],
            "okp": "4a6f100d-72e25fee-494d5ea0-d00b7bb8-166ab88a",
            "pkp": "OhI/bUdkSi9hRXsBm6Hymv9tKo9Yo2ZULuxSiLlHMXhlwmRHoQLnMmehnqs68m6iH3juPR/5r9wiAuuY/dOigTrd70dRLbHtGU4PNeI+IIC/2VUFucN2kfl4Ehx5jzBGVAWxAbESX40SN2RskRXK8hXze954YN01feTlq+FLtYW7hp25ckWUYSRN1StpNEv8Klm2qQ62U51VzKc1Xo5RoWoB7ZUydnDKkDyWUT1Vw/Eg/k8a/4Hk+Xrd+Vn1gXGSvYmkGBDHdC7aTp87FQ/NtjvJDF0embjqzJpBqkmafu9fsUL/fqNU/ygV8VLbbBd7SyzyyAUBLAhXdtWaPDWBYA==",
            "payments": [{
                "name": "Hotovosť",
                "amount": 3.50
            }],
            "headerText": "Nine Digit, s.r.o.",
            "footerText": "Ďakujeme za nákup!",
            "createDate": "2023-09-11T18:14:11+02:00",
            "dic": "1234567890",
            "cashRegisterCode": "88812345678900001"
        },
        "id": "f00d1cea-6d8d-46ac-9877-09ca29f90ef5",
        "externalId": "EID-0094736",
        "date": "2023-09-11T18:14:11+02:00",
        "sendingCount": 1
    },
    "response": {
        "data": {
            "id": "O-0A3730BF772041C9B730BF77205-TEST"
        },
        "processDate": "2023-09-11T18:14:12+02:00"
    },
    "isSuccessful": true,
    "error": {
        "message": "Chyba v podpise dátovej správy.",
        "code": -10
    },
    "$type": "Receipt"
}';

        $result = $serializer->deserialize($json, $type);

        $this->assertInstanceOf(RegisterReceiptResultDto::class, $result);
        $this->assertInstanceOf(RegisterReceiptResultRequestDto::class, $result->request);
        $this->assertInstanceOf(ReceiptRegistrationDataDto::class, $result->request->data);

        $this->assertEquals(ReceiptType::CASH_REGISTER, $result->request->data->receiptType);
        $this->assertEquals(3.50, $result->request->data->amount);
        $this->assertEquals(0.02, $result->request->data->roundingAmount);
        $this->assertEquals(
            DateTimeHelper::createEuropeBratislava(2023, 9, 11, 18, 14, 11),
            $result->request->data->issueDate
        );
        $this->assertEquals(6, $result->request->data->receiptNumber);
        $this->assertEquals("201801001", $result->request->data->invoiceNumber);
        $this->assertEquals(429, $result->request->data->paragonNumber);
        $this->assertEquals("SK1234567890", $result->request->data->icdph);
        $this->assertEquals("76543210", $result->request->data->ico);
        $this->assertEquals(0.58, $result->request->data->basicVatAmount);
        $this->assertEquals(0.00, $result->request->data->reducedVatAmount);
        $this->assertEquals(0.00, $result->request->data->reducedVatAmount);
        $this->assertEquals(0.00, $result->request->data->taxFreeAmount);
        $this->assertEquals(2.90, $result->request->data->taxBaseBasic);
        $this->assertEquals(0.00, $result->request->data->taxBaseReduced);
        $this->assertEquals("4a6f100d-72e25fee-494d5ea0-d00b7bb8-166ab88a", $result->request->data->okp);
        $this->assertEquals("OhI/bUdkSi9hRXsBm6Hymv9tKo9Yo2ZULuxSiLlHMXhlwmRHoQLnMmehnqs68m6iH3juPR/5r9wiAuuY/dOigTrd70dRLbHtGU4PNeI+IIC/2VUFucN2kfl4Ehx5jzBGVAWxAbESX40SN2RskRXK8hXze954YN01feTlq+FLtYW7hp25ckWUYSRN1StpNEv8Klm2qQ62U51VzKc1Xo5RoWoB7ZUydnDKkDyWUT1Vw/Eg/k8a/4Hk+Xrd+Vn1gXGSvYmkGBDHdC7aTp87FQ/NtjvJDF0embjqzJpBqkmafu9fsUL/fqNU/ygV8VLbbBd7SyzyyAUBLAhXdtWaPDWBYA==", $result->request->data->pkp);
        $this->assertEquals("Nine Digit, s.r.o.", $result->request->data->headerText);
        $this->assertEquals("Ďakujeme za nákup!", $result->request->data->footerText);
        $this->assertEquals(
            DateTimeHelper::createEuropeBratislava(2023, 9, 11, 18, 14, 11),
            $result->request->data->createDate
        );
        $this->assertEquals("1234567890", $result->request->data->dic);
        $this->assertEquals("88812345678900001", $result->request->data->cashRegisterCode);

        // Items
        $this->assertIsArray($result->request->data->items);
        $this->assertCount(1, $result->request->data->items);

        // Item[0]
        $this->assertInstanceOf(ReceiptItemDto::class, $result->request->data->items[0]);
        $this->assertEquals(ReceiptItemType::POSITIVE, $result->request->data->items[0]->type);
        $this->assertEquals("Coca Cola 0.25l", $result->request->data->items[0]->name);
        $this->assertEquals(2.58, $result->request->data->items[0]->price);
        $this->assertEquals(1.29, $result->request->data->items[0]->unitPrice);
        $this->assertInstanceOf(QuantityDto::class, $result->request->data->items[0]->quantity);
        $this->assertEquals(2.0000, $result->request->data->items[0]->quantity->amount);
        $this->assertEquals("ks", $result->request->data->items[0]->quantity->unit);
        $this->assertEquals("O-7DBCDA8A56EE426DBCDA8A56EE426D1A", $result->request->data->items[0]->referenceReceiptId);
        $this->assertEquals(20.00, $result->request->data->items[0]->vatRate);
        $this->assertEquals("UsedGood", $result->request->data->items[0]->specialRegulation);
        $this->assertEquals("201801001", $result->request->data->items[0]->voucherNumber);
        $this->assertInstanceOf(SellerDto::class, $result->request->data->items[0]->seller);
        $this->assertEquals("SK1234567890", $result->request->data->items[0]->seller->id);
        $this->assertEquals(SellerIdType::ICDPH, $result->request->data->items[0]->seller->type);
        $this->assertEquals("Tovar", $result->request->data->items[0]->description);

        // Payments
        $this->assertIsArray($result->request->data->payments);
        $this->assertCount(1, $result->request->data->payments);

        // Payment[0]
        $this->assertInstanceOf(ReceiptPaymentDto::class, $result->request->data->payments[0]);
        $this->assertEquals("Hotovosť", $result->request->data->payments[0]->name);
        $this->assertEquals(3.50, $result->request->data->payments[0]->amount);

        $this->assertEquals("f00d1cea-6d8d-46ac-9877-09ca29f90ef5", $result->request->id);
        $this->assertEquals("EID-0094736", $result->request->externalId);
        $this->assertEquals(DateTimeHelper::createEuropeBratislava(2023, 9, 11, 18, 14, 11), $result->request->date);
        $this->assertEquals(1, $result->request->sendingCount);

        $this->assertInstanceOf(RegisterReceiptResultResponseDto::class, $result->response);
        $this->assertInstanceOf(ReceiptRegistrationResultReceiptDataDto::class, $result->response->data);
        $this->assertEquals("O-0A3730BF772041C9B730BF77205-TEST", $result->response->data->id);
        $this->assertEquals(
            DateTimeHelper::createEuropeBratislava(2023, 9, 11, 18, 14, 12),
            $result->response->processDate
        );

        $this->assertTrue(true, $result->isSuccessful);
        $this->assertInstanceOf(EKasaErrorDto::class, $result->error);
        $this->assertEquals("Chyba v podpise dátovej správy.", $result->error->message);
        $this->assertEquals(-10, $result->error->code);
    }

    public function testValidationProblemDetailsDeserialization()
    {
        $serializer = new SymfonyJsonSerializer();
        $type = ValidationProblemDetails::class;

        $json = '{
      "errors": {
          "Request.Items": [
              "\'Items\' must not be empty."
          ]
      },
      "type": "https://tools.ietf.org/html/rfc7231#section-6.5.1",
      "title": "One or more validation errors occurred.",
      "status": 400,
      "traceId": "00-3883c3382a81f24ca6ac58a375d6de64-d99c7a32e359d24f-00"
    }';

        $details = $serializer->deserialize($json, $type);

        $this->assertInstanceOf(ValidationProblemDetails::class, $details);

        $this->assertIsArray($details->errors);
        $this->assertCount(1, $details->errors);
        $this->assertArrayHasKey("Request.Items", $details->errors);
        $this->assertIsArray($details->errors["Request.Items"]);
        $this->assertCount(1, $details->errors["Request.Items"]);
        $this->assertEquals("'Items' must not be empty.", $details->errors["Request.Items"][0]);

        $this->assertEquals("https://tools.ietf.org/html/rfc7231#section-6.5.1", $details->type);
        $this->assertEquals("One or more validation errors occurred.", $details->title);
        $this->assertEquals(400, $details->status);
        $this->assertEquals("00-3883c3382a81f24ca6ac58a375d6de64-d99c7a32e359d24f-00", $details->traceId);
    }

    public function testProblemDetailsDeserialization()
    {
        $serializer = new SymfonyJsonSerializer();
        $type = ProblemDetails::class;

        $json = '{
      "title": "General error",
      "status": 403,
      "instance": "/api/v1/requests/receipts",
      "code": -100,
      "traceId": "0HMCTVDF5NB0B:00000002"
    }';

        $details = $serializer->deserialize($json, $type);

        $this->assertInstanceOf(ProblemDetails::class, $details);

        $this->assertEquals("General error", $details->title);
        $this->assertEquals(403, $details->status);
        $this->assertEquals("/api/v1/requests/receipts", $details->instance);
        $this->assertEquals(ApiErrorCode::GENERAL_ERROR, $details->code);
        $this->assertEquals("0HMCTVDF5NB0B:00000002", $details->traceId);
    }
}
