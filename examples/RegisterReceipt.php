<?php

namespace NineDigit\eKasa\Client\Examples;

use Error;
use NineDigit\eKasa\Client\AccessTokenSource;
use NineDigit\eKasa\Client\ApiClientAuthenticationAccessTokenOptions;
use NineDigit\eKasa\Client\ApiClientAuthenticationOptions;
use NineDigit\eKasa\Client\Credentials;
use NineDigit\eKasa\Client\EKasaServer;
use NineDigit\eKasa\Client\ApiClient;
use NineDigit\eKasa\Client\ApiClientOptions;
use NineDigit\eKasa\Client\Models\QuantityDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\EmailRegisterReceiptPrintContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PdfReceiptPrinterOptions;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PdfRegisterReceiptPrintContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PosReceiptPrinterOptions;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\EmailReceiptPrinterOptions;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PosRegisterReceiptPrintContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptBuilder;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptItemBuilder;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptItemDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptItemType;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptPaymentDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptPaymentName;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestDto;

require '../vendor/autoload.php';

//////////////////////////////////////////////////

// 1. Nastavenie klienta

    // 1.1. Nastavenia adresy eKasa API servera

    // Ak sa pripájate cez internet a máte zakúpenú službu Expose
    $url = EKasaServer::exposeDefault("my-shop");
    // Ak sa pripájate cez lokálnu sieť
    $url = EKasaServer::LOCALHOST;

    // 1.2 Nastavenie autentifikácie

    // 1.2.1 Ak je zapnuté zabezpečenie (viďte WebAdmin (http://localhost:3010) ->
    // Nastavenia -> Ostatné -> Zabezpečenie)
    $credentials = new Credentials("admin", "admin");

    // 1.2.2 Ak sa pripájate cez internet a máte zakúpenú službu Expose.
    $accessTokenSource = AccessTokenSource::queryString("access_token");
    $accessTokenOptions = new ApiClientAuthenticationAccessTokenOptions("31d6cfe0d16ae931b73c59d7", $accessTokenSource);

    $authentication = new ApiClientAuthenticationOptions($credentials, $accessTokenOptions);

    // 1.3. Nastavenie Proxy servera
    $proxyUrl = "http://192.168.1.100:9090"; // Url adresa proxy servera, inak null

// 2. Vytvorenie inštancie klienta
$clientOptions = new ApiClientOptions($url, $authentication, $proxyUrl);
$client = new ApiClient($clientOptions);

/**
 * Kód on-line registračnej pokladne.
 */
$cashRegisterCode = "88812345678900001";

/*
 * Identifikátor požiadavky, priradený nadradenou aplikáciou.
 * Spolu s ORP kódom tvoria unikátny identifikátor požidavky naprieč systémom.
 */
$externalId = "e52ff4d1-f2ed-4493-9e9a-a73739b1ba23";

/**
 * Konfigurácia tlačiarne, na ktorej bude doklad spracovaný.
 * K dispozícií sú nasledovné:
 */

    // 2.1. Tlačiareň papierových dokladov
    $posPrinterOptions = new PosReceiptPrinterOptions();
    $posPrinterOptions->openDrawer = true;
    $print = new PosRegisterReceiptPrintContextDto($posPrinterOptions);

    // 2.2. Tlačiareň vyhotovujúca PDF súbory
    $pdfPrinterOptions = new PdfReceiptPrinterOptions();
    $print = new PdfRegisterReceiptPrintContextDto($pdfPrinterOptions);

    // 2.3. Tlačiareň vyhotovujúca e-maily
    $emailPrinterOptions = new EmailReceiptPrinterOptions("mail@example.com");
    $emailPrinterOptions->subject = "Váš elektronický doklad";
    $print = new EmailRegisterReceiptPrintContextDto($emailPrinterOptions);

// Položky dokladu

$items = array(
    new ReceiptItemDto(
        ReceiptItemType::POSITIVE, // Kladný typ položky
        "Coca Cola 0.25l", // Názov
        1.29, // Jednotková cena
        20.00, // Daňová hladina
        new QuantityDto(2, "ks"), // Množstvo
        2.58 // Cena
    ),
    // Alternatívna konštrukcia položky dokladu
    ReceiptItemBuilder::positive(
        "Sprite 0.33l",
        2.00,
        20.00,
        new QuantityDto(1, "ks"),
        2.00
    )
        ->setDescription("Akčná cena")
        ->build()
);

// Doklad
$receipt = ReceiptBuilder::cashRegister($cashRegisterCode, $items)
    ->setRoundingAmount(0.02)
    ->addPayment(new ReceiptPaymentDto(4.00, ReceiptPaymentName::CASH))
    ->addPayment(new ReceiptPaymentDto(-0.50, "Výdavok"))
    ->setHeaderText("Nine Digit, s.r.o.") // Voliteľná hlavička dokladu
    ->setFooterText("Ďakujeme za nákup!") // Voliteľná pätička dokladu
    ->build();

$request = new RegisterReceiptRequestDto($receipt, $externalId);
$requestContext = new RegisterReceiptRequestContextDto($print, $request);

// Zaslanie požidavky a obdržanie výsledku
$result = $client->registerReceipt($requestContext);

if ($result->isSuccessful === true) {
    // Doklad bol úspešne spracovaný v režíme ON-LINE
    // ...
} elseif ($result->isSuccessful === null) {
    // Doklad bol úspešne spracovaný v režíme OFF-LINE
    // ...
} else {
     // Spracovanie dokladu zlyhalo
    throw new Error("Spracovanie dokladu zlyhalo: {$result->error->message} [{$result->error->code}].");
}
