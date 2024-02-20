# PHP PASSBOOK LIBRARY

[![Code Coverage](https://scrutinizer-ci.com/g/eymengunay/php-passbook/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/eymengunay/php-passbook/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/eymengunay/php-passbook/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/eymengunay/php-passbook/?branch=master)
[![PHPUnit](https://github.com/eymengunay/php-passbook/actions/workflows/test.yml/badge.svg)](https://github.com/eymengunay/php-passbook/actions/workflows/test.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/eo/passbook.svg)](https://packagist.org/packages/eo/passbook)
[![Latest Stable Version](https://img.shields.io/packagist/v/eo/passbook.svg)](https://packagist.org/packages/eo/passbook)

## What is Passbook?

> Passbook is an application in iOS that allows users to store coupons, boarding passes, event tickets,
> store cards, 'generic' cards and other forms of mobile payment.

## What does this library do?

PHP-Passbook is a library for creating and packaging passes inside your application. Distribution of generated pass files can be done by attaching the file in an e-mail or serving it from your web server.

## Breaking changes

### Version 3.0.0

* Requires PHP >= 7.4

### Version 2.0.0

* `Image` class `setRetina`/`isRetina` methods replaced with `setDensity`/`getDensity`.

## Installing

### Using Composer

To add PHP-Passbook as a local, per-project dependency to your project, simply add a dependency on eo/passbook to your project's composer.json file. Here is a minimal example of a composer.json file that just defines a development-time dependency on the latest version of the library:

```json
{
    "require": {
        "eo/passbook": "dev-master"
    }
}
```

## Supported pass types

The following table<sup>[link](https://github.com/google-wallet/pass-converter?tab=readme-ov-file#supported-pass-types)</sup> shows the mapping of pass types between each supported wallet platform.

| Type          | Google Wallet                                                                                                | Apple Wallet                                                                                                         |
| ------------- | ------------------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------------------------------- |
| Boarding pass | [`FlightObject`](https://developers.google.com/wallet/tickets/boarding-passes/rest/v1/flightobject)          | [`Pass.BoardingPass` (`PKTransitTypeAir`)](https://developer.apple.com/documentation/walletpasses/pass/boardingpass) |
| Transit pass  | [`TransitObject`](https://developers.google.com/wallet/tickets/transit-passes/qr-code/rest/v1/transitobject) | [`Pass.BoardingPass` (other types)](https://developer.apple.com/documentation/walletpasses/pass/boardingpass)        |
| Offer/Coupon  | [`OfferObject`](https://developers.google.com/wallet/retail/offers/rest/v1/offerobject)                      | [`Pass.Coupon`](https://developer.apple.com/documentation/walletpasses/pass/coupon)                                  |
| Event ticket  | [`EventTicketObject`](https://developers.google.com/wallet/tickets/events/rest/v1/eventticketobject)         | [`Pass.EventTicket`](https://developer.apple.com/documentation/walletpasses/pass/eventticket)                        |
| Loyalty card  | [`LoyaltyObject`](https://developers.google.com/wallet/retail/loyalty-cards/rest/v1/loyaltyobject)           | [`Pass.StoreCard`](https://developer.apple.com/documentation/walletpasses/pass/storecard)                            |
| Generic       | [`GenericObject`](https://developers.google.com/wallet/generic/rest/v1/genericobject)                        | [`Pass.Generic`](https://developer.apple.com/documentation/walletpasses/pass/generic)          

## API Doc
Search by class, method name, or package: http://eymengunay.github.io/php-passbook/api

## Usage Example

This example will create a pass of type Ticket and will save the pkpass file in the output path specified. To use this example, you will need to do the following and set the constants accordingly:

* [Create a P12 Certificate file](#p12-certificate)
* [Download Apple’s World Wide Developer Relations (WWDR) certificate](#wwdr-certificate)
* [Obtain a Pass Type Identifier and Team Identifier from Apple](#obtaining-the-pass-type-identifier-and-team-id)
* Get an icon (29x29 png file) for the pass
* Specify a name for your organization
* Specify the output path where the pass will be saved

```php
<?php

use Passbook\Apple\Field;
use Passbook\Apple\Image;
use Passbook\ApplePassFactory;
use Passbook\Apple\Barcode;
use Passbook\Apple\PassFields;
use Passbook\Type\EventTicket;

// Set these constants with your values
define('P12_FILE', '/path/to/p12/certificate.p12');
define('P12_PASSWORD', 'password_for_p12_file');
define('WWDR_FILE', '/path/to/wwdr.pem');
define('PASS_TYPE_IDENTIFIER', 'pass.com.example.yourpass');
define('TEAM_IDENTIFIER', 'IDFROMAPPLE');
define('ORGANIZATION_NAME', 'Your Organization Name');
define('OUTPUT_PATH', '/path/to/output/path');
define('ICON_FILE', '/path/to/icon.png');

// Create an event ticket
$pass = new EventTicket("1234567890", "The Beat Goes On");
$pass->setBackgroundColor('rgb(60, 65, 76)');
$pass->setLogoText('Apple Inc.');

// Create pass structure
$structure = new PassFields();

// Add primary field
$primary = new Field('event', 'The Beat Goes On');
$primary->setLabel('Event');
$structure->addPrimaryField($primary);

// Add secondary field
$secondary = new Field('location', 'Moscone West');
$secondary->setLabel('Location');
$structure->addSecondaryField($secondary);

// Add auxiliary field
$auxiliary = new Field('datetime', '2013-04-15 @10:25');
$auxiliary->setLabel('Date & Time');
$structure->addAuxiliaryField($auxiliary);

// Add icon image
$icon = new Image(ICON_FILE, 'icon');
$pass->addImage($icon);

// Set pass structure
$pass->setPassFields($structure);

// Add barcode
$barcode = new Barcode(Barcode::TYPE_QR, 'barcodeMessage');
$pass->setBarcode($barcode);

// Create pass factory instance
$factory = new ApplePassFactory(PASS_TYPE_IDENTIFIER, TEAM_IDENTIFIER, ORGANIZATION_NAME, P12_FILE, P12_PASSWORD, WWDR_FILE);
$factory->setOutputPath(OUTPUT_PATH);
$factory->package($pass);
```

## Requirements
* PHP 5.4+
* [zip](http://php.net/manual/en/book.zip.php)
* [OpenSSL](http://www.php.net/manual/en/book.openssl.php)

Version 1.2.0 is the last release to support PHP 5.3.

## Obtaining the Pass Type Identifier, Team ID and Issuer ID

You can find more information from Apple on [setting the Pass Type Identifier and Team ID](https://developer.apple.com/library/ios/documentation/UserExperience/Conceptual/PassKit_PG/YourFirst.html#//apple_ref/doc/uid/TP40012195-CH2-SW27).

Check [Google Wallet prerequisites](https://developers.google.com/wallet/generic/web/prerequisites) for creating your Google Wallet API Issuer account.

## Requesting Certificates

### P12 Certificate
Once you have downloaded the Apple iPhone certificate from Apple, export it to the P12 certificate format.

**To do this on Mac OS:**

1. Open the Keychain Access application (in the Applications/Utilities folder).
2. If you have not already added the certificate to Keychain, select File > Import. Then navigate to the certificate file (the .cer file) you obtained from Apple.
3. Select the Keys category in Keychain Access.
4. Select the private key associated with your iPhone Development Certificate. The private key is identified by the iPhone Developer: <First Name> <Last Name> public certificate that is paired with it.
5. Select File > Export Items.
6. Save your key in the Personal Information Exchange (.p12) file format.
7. You will be prompted to create a password that is used when you attempt to import this key on another computer.

**on Windows:**

1. Convert the developer certificate file you receive from Apple into a PEM certificate file. Run the following command-line statement from the OpenSSL bin directory:

```
openssl x509 -in developer_identity.cer -inform DER -out developer_identity.pem -outform PEM
```

2. If you are using the private key from the keychain on a Mac computer, convert it into a PEM key:

```
openssl pkcs12 -nocerts -in mykey.p12 -out mykey.pem
```

3. You can now generate a valid P12 file, based on the key and the PEM version of the iPhone developer certificate:

```
openssl pkcs12 -export -inkey mykey.key -in developer_identity.pem -out iphone_dev.p12
```

If you are using a key from the Mac OS keychain, use the PEM version you generated in the previous step. Otherwise, use the OpenSSL key you generated earlier (on Windows).

### WWDR Certificate
Apple’s World Wide Developer Relations (WWDR) certificate is available from Apple at <http://developer.apple.com/certificationauthority/AppleWWDRCA.cer>. You will have to add this to your Keychain Access and export it in .pem format to use it with the library. The WWDR certificate links your development certificate to Apple, completing the trust chain for your application.

## Running Tests
Before submitting a patch for inclusion, you need to run the test suite to check that you have not broken anything.

To run the test suite, install PHPUnit 3.7 (or later) first.

### Dependencies
To run the entire test suite, including tests that depend on external dependencies, php-passbook needs to be able to autoload them. By default, they are autoloaded from vendor/ under the main root directory (see vendor/autoload.php).

To install them all, use [Composer](http://getcomposer.org):

Step 1: Get [Composer](http://getcomposer.org)
```
curl -s http://getcomposer.org/installer | php
```
Make sure you download composer.phar in the same folder where the composer.json file is located.

Step 2: Install vendors
```
php composer.phar install
```

> Note that the script takes some time to finish.

### Running
First, install the vendors (see above).

Then, run the test suite from the package root directory with the following command:
```
phpunit
```

The output should display OK. If not, you need to figure out what's going on and if the tests are broken because of your modifications.

## Reporting an issue or a feature request
Issues and feature requests related to this library are tracked in the Github issue tracker: https://github.com/eymengunay/php-passbook/issues

## Contributing

Contributions are welcome and will be fully credited. We accept contributions via Pull Requests here on GitHub.

Please note that this project adhered to [PSR-12 Extended Coding Style Guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-12-extended-coding-style-guide.md), so your changes need to:
- Have PHPUnit-test coverage and tests must pass with all supported PHP versions
- Pass PHPStan & PHP_CodeSniffer static analysis checks
- Be documented in `README.md` for any change in behaviour

## Donating

If you want to support the project, please consider to donate a small amount using GitHub Sponsors button. Thank you for your support!

## See also
[PassbookBundle](https://github.com/eymengunay/PassbookBundle): PHP-Passbook library integration for Symfony2
