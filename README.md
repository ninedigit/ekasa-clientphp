
# e-Kasa Client PHP

HTTP klient v jazyku PHP pre [e-Kasa API riešenie](https://ekasa.ninedigit.sk) spoločnosti [Nine Digit, s.r.o.](https://ninedigit.sk/).

# Inštalácia

Knižnica je kompatibilná s PHP vo verzii 7.4, 8.1 a vyššej.

## Inštalácia cez Packagist

Knižnica je dostupná na https://packagist.org/packages/ninedigit/ekasa-clientphp.

Najnovšiu verziu balíka nainštalujete príkazom:

```shell
composer require ninedigit/ekasa-clientphp
```

Inštaláciu špecifickej verzie nainštalujete príkazom:

```shell
composer require ninedigit/ekasa-clientphp:0.0.1
```

## Inštalácia cez GitHub repozitár

1. Upravte súbor `composer.json` a do kolekcie `repositories` pridajte nový repozitár:

```
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/ninedigit/ekasa-clientphp"
    }
  ]
}
```

2. Nainštalujte balík

Najnovšiu verziu balíka nainštalujete príkazom:

```shell
composer require ninedigit/ekasa-clientphp
```

Inštaláciu špecifickej verzie nainštalujete príkazom:

```shell
composer require ninedigit/ekasa-clientphp:0.0.1
```

> Viac informácii o inštalácii privátnych repozitárov nájdete [v Composer dokumentácii](https://getcomposer.org/doc/05-repositories.md#using-private-repositories).

# Použitie

> Knižnica aktuálne pokrýva iba funkcionalitu registrácie dokladu. Ak máte záujem o rozšírenie, zadajte prosím dopyt na [info@ninedigit.sk](mailto:info@ninedigit.sk).

Knižnicu je možné používať v dvoch režimoch:

## Cez lokálnu sieť

Služba je po inštalácií štandardne dostupná na porte `3010` (`http://localhost:3010`).

Klientskú triedu inštanciujte nasledovne:

```php
$clientOptions = new ApiClientOptions(EKasaServer::LOCALHOST);
$client = new ApiClient($clientOptions);
```

> TIP: Ak ste integrátor a potrebujete testovaciu eKasa API inštanciu, postupujte podľa [tohto návodu](INTEGRATOR.md).

## Cez internet so službou Expose 

Ak je vaša PHP aplikácia používajúca túto knižnicu nasadená na inom počítači (na serveri resp. v cloude), je potrebné zabezpečiť sieťové spojenie s lokálne nainštalovanou eKasa API.

Riešením je práve služba **Expose**, ktorá priradí k vašej lokálne nainštalovanej eKasa API URL adresu s použitím zabezpečeného HTTPS protokolu.

- Nie je potrebné žiadne nastavenie smerovača (routra) či obstarávanie statickej IP adresy u internetového poskytovateľa.
- Nadviazané spojenie je šifrované
- Prístup k eKasa API službe je chránený nastaveným prístupovým kľúčom, ktorý je možné kedykoľvek aktualizovať.

Pre aktiváciu služby a získanie prihlasovacích údajov nás kontaktujte na e-mailovej adrese [info@ninedigit.sk](mailto:info@ninedigit.sk).

Pri použití Expose služby inštanciujete klientskú triedu nasledovne:

```php
$url = EKasaServer::exposeProduction("{vas_nazov_domeny}");
$accessTokenSource = AccessTokenSource::queryString("access_token");
$accessTokenOptions = new ApiClientAuthenticationAccessTokenOptions("{vas_bezpecnostny_kluc}", $accessTokenSource);
$authentication = new ApiClientAuthenticationOptions(null, $accessTokenOptions);
$clientOptions = new ApiClientOptions($url, $authentication);
$client = new ApiClient($clientOptions);
```

## Príklady

> Príklady sú dostupné v adresári [examples](https://github.com/ninedigit/ekasa-clientphp/tree/master/examples).

### Príklad tvorby pokladničného dokladu

```php
// Vytvorenie klienta
$clientOptions = new ApiClientOptions(EKasaServer::LOCALHOST);
$client = new ApiClient($clientOptions);

// Nastavenia tlače
$posPrinterOptions = new PosReceiptPrinterOptions();
$posPrinterOptions->openDrawer = true;
$print = new PosRegisterReceiptPrintContextDto($posPrinterOptions);

// Položka
$items = array(
  new ReceiptItemDto(
    ReceiptItemType::POSITIVE,  // Kladný typ položky
    "Coca Cola 0.25l",          // Názov
    1.29,                       // Jednotková cena
    20.00,                      // Daňová hladina
    new QuantityDto(2, "ks"),   // Množstvo
    2.58                        // Cena
  )
);

// Požiadavka registrácie
$receipt = ReceiptBuilder::cashRegister("88812345678900001", $items)
    ->setHeaderText("Nine Digit, s.r.o.") // Voliteľná hlavička dokladu
    ->setFooterText("Ďakujeme za nákup!") // Voliteľná pätička dokladu
    ->addPayment(new ReceiptPaymentDto(2.60, ReceiptPaymentName::CASH))
    ->addPayment(new ReceiptPaymentDto(-0.02, "Výdavok"))
    ->build();

$request = new RegisterReceiptRequestDto($receipt);
$requestContext = new RegisterReceiptRequestContextDto($print, $request);

// Registrácia
$result = $client->registerReceipt($requestContext);
```

### Zaokrúhľovanie

V prípade, ak do premenných vkladáte výsledky matematických operácii, pred priradením je vhodné premenné zaokrúhliť.

- Jednotkové ceny sú zaokrúhľované na 6 desatinných miest.
- Ceny sú zaokrúhľované na 2 desatinné miesta.
- Množstvá sú zaokrúhľované na 4 desatinné miesta.


# Vývoj

## Inštalácia Composer-a

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

Inštalácia závislostí knižnice:

```shell
php composer.phar install
```

Po vytvorení nových tried (v separátnych súboroch) je nutné vyvolať

```shell
php composer.phar dump-autoload
```

# Testovanie

Pre vykonanie integračných testov je nutné vytvoriť súbor `settings.json` v `tests\integration` vo formáte **JSON** so štruktúrou zhodnou s triedou `ApiClientOptions`.

Napríklad:

```json
{
  "url": "https://test.expose.ninedigit.sk",
  "proxyUrl": "192.168.1.218:9090",
  "authentication": {
    "credentials": {
      "userName": "admin",
      "password": "admin"
    },
    "accessToken": {
      "value": "31d6cfe0d16ae931b73c59d7",
      "source": {
        "name": "queryString",
        "keyName": "access_token"
      }
    }
  }
}
```

Testy je možné spustiť príkazom:

```shell
./vendor/bin/phpunit --verbose tests
```

Pre spustenie konkrétneho testu je nutné uviesť prepínač `--filter` s názvom testovaciej metódy.

Napríklad:

```
./vendor/bin/phpunit --verbose tests --filter testRegisterCashRegisterReceiptUsingPosPrinter
```

## Overenie kompatibility PHP

```
./vendor/bin/phpcs --standard=PHPCompatibility --extensions=php --runtime-set testVersion 8.1- ./src
```