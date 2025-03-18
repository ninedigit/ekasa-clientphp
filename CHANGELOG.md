# Changelog

Všetky významné zmeny v projekte budú uvedené v tomto dokumente.

Formát dokumentu vychádza z [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
a dodržiava [sémantické verzionovanie](https://semver.org/spec/v2.0.0.html).

## [0.0.1] - 2023-09-12
 - Prvá verzia knižnice

## [0.0.2] - 2023-10-24
 - Aktualizovaný README.md dokument.
 - Pridaná `debug` vlastnosť do triedy `ApiClientOptions`.
 - Opravená kompozícia dokladu triedou `ReceiptBuilder`.
 - Migrácia na `Guzzle@^7.0`.

## [0.0.3] - 2023-11-13
 - Oprava chyby, kedy klient vytvoril nesprávu URL adresu pre integračné/produkčné prostredie.
 - Aktualizované README.md a INTEGRATOR.md dokumenty.
 - Vytvorená migračná príručka MIGRATION.md.

## [0.0.4] - 2023-11-13
 - Oprava chyby, kedy vlastnosti triedy `ApiResponseMessage` neboli nastavené.
 - Vylepšené vyhodnocovanie odopovede zo servera.

## [0.0.5] - 2023-11-20
 - Vylepšené vyhodnocovanie odopovede zo servera.

## [0.0.6] - 2023-11-21
 - Vylepšené vyhodnocovanie odopovede zo servera.
 - Vytvorená nová trieda výnimky `ExposeException` pre chyby *Expose* služby.
 - Vytvorená nová trieda výnimky `ResponseException`. Tá je základným typom pre triedy `ApiException` (výnimka pre chyby *eKasa API* služby) a `ExposeException`.
 - Vytvorená nová trieda `ExposeError`. Tá obsahuje identifikátor chyby *Expose* služby.

## [0.0.7] - 2023-12-01
 - Doplnené typové anotácie `@var` na vlastnosti deserializovaných modelov
 - Opravené chyby v dokumentačných súboroch *INTEGRATOR.md* a *README.md*

## [1.0.0] - 2023-12-07
 - Trieda `EKasaEnvironment` je nahradená triedou `EKasaServer` a bude vymazaná vo verzií *2.0.0*.
 - Pridaný nový chybový kód do `ApiErrorCode` `UNAUTHENTICATED`.
 - Pridaná chyba `ApiAuthenticationException`, ktorá nastane po zlyhaní prihlásenia.
 - Pridaná nová trieda `AuthenticationSchemeName`, ktorá obsahuje zoznam autentifikačných schém. Tá je užitočná pri vyhodnocovaní chyby `ApiAuthenticationException`.

### Zmeny netýkajúce sa konzumenta knižnice
 - Trieda `HttpClient` je testovateľná pomocou triedy `TestableHttpClient`.
 - Všetky vlastnosti triedy `ApiResponseMessage` boli nahradené metódami a boli pridané nové metódy.
 - Pridané "enumeračné" triedy `AuthenticationSchemeName`, `HeaderName` a `MediaTypeName`.

## [1.1.0] - 2023-12-18
 - Aktualizácia závislostí.

## [1.2.0] - 2023-12-20
 - Oprava chyby deserializácie triedy `ReceiptRegistrationDataDto` (`The type of the "data" attribute for class "NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptResultRequestDto" must be one of "NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptregistrationDataDto" ("array" given).`).

## [1.3.0] - 2023-12-21
 - Úprava verzie závislosti `doctrine/annotations` z `^2.0` na `^1.13 || ^2.0`.

## [2.0.0] - 2024-02-12
 - Úprava verzie závislosti PHP z `7.4.0` na `8.1.0` a `symfony/*` z `^5.4` na `^6.4`
 - Úprava súboru `LICENSE`

## [2.0.1] - 2024-02-12
 - Oprava verzie závislosti PHP z `>=7.4` na `>=8.1`

## [2.1.0] - 2024-02-14
 - Pridaná podpora pre `symfony/* ^5.4` a `php ^7.4`

## [2.1.1] - 2024-04-24
 - Pridaná nová metóda `getProductInfo` do triedy `ApiClient`

## [2.1.3] - 2024-10-02
 - Oprava chyby, kedy dopyt URL adresy bol nesprávne skonštruovaný pre viac ako jeden parameter
 - Oprava chyby, kedy vlastnosť `payload` triedy `ApiRequestMessage` bola serializovaná ako reťazec s hodnotou `"null"` namiesto `null`

## [2.1.4] - 2024-10-31
 - Pridaná nová metóda `receiveRaw` do triedy `HttpClient`
 - Pridané nové hodnoty do triedy `MediaTypeName`
 - Pridané nové metódy na zistenie typu obsahu odpovede v triede `ApiResponseMessage`
 - Pridaná nová metóda `getContent` do triedy `ApiReponseMessage`, ktorá dobudúcna nahradí metódu `getBody`

## [3.0.0] - 2024-11-12
 - Úprava dátového typu `vatRate` objektu `ReceiptItemDto`, ktorý môže akceptovať aj `null` hodnotu pre položky nepodiehajúce DPH.
 - Pridané vlastnosti `secondReducedVatAmount` a `taxBaseSecondReduced` do triedy `ReceiptRegistrationDataDto` súvisiace so zmenou DPH

 Viac informácií o nadchádzajúcich legislatívnych zmenách nájdete na stránkach [Aktualizácia k zmenám platným od 1.1.2025](https://ekasa.ninedigit.sk/aktualizacia-k-zmenam-platnym-od-1-1-2025), [Migrácia na verziu 7](https://ekasa.ninedigit.sk/docs/articles/migration-guides/v7?tabs=sk), [Vat Rate - Sadzba dane z pridanej hodnoty](https://ekasa.ninedigit.sk/docs/articles/receipt-registration?tabs=tabid-1#27-vatrate---sadzba-dane-z-pridanej-hodnoty) a [Odpočet prijatej zálohy](https://ekasa.ninedigit.sk/docs/articles/receipt-registration#14-odpo%C4%8Det-prijatej-z%C3%A1lohy).

## [3.0.1] - 2024-11-12
 - Pridané vlastnosť `nonTaxableAmount` do triedy `ReceiptRegistrationDataDto`

## [3.1.0] - 2025-03-18
 - Vlastnosť `print` triedy `RegisterReceiptRequestContextDto` môže nadobudnúť hodnotu `null`