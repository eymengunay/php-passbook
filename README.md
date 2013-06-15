# PHP PASSBOOK LIBRARY

[![Dependencies Status](https://d2xishtp1ojlk0.cloudfront.net/d/5913521)](http://depending.in/eymengunay/php-passbook)

## Installing

### Using Composer

To add PHP-Passbook as a local, per-project dependency to your project, simply add a dependency on eo/passbook to your project's composer.json file. Here is a minimal example of a composer.json file that just defines a development-time dependency on the latest version of the library:

```
{
    "require-dev": {
        "eo/passbook": "dev-master"
    }
}
```

## API Doc
Search by class, method name, or package: http://eymengunay.github.io/php-passbook/api

## Usage Example

```
<?php

...

use Passbook\Pass\Field;
use Passbook\PassFactory;
use Passbook\Pass\Barcode;
use Passbook\Pass\Structure;
use Passbook\Type\EventTicket;

// Create an event ticket
$pass = new EventTicket("1234567890", "The Beat Goes On");
$pass->setBackgroundColor('rgb(60, 65, 76)');
$pass->setLogoText('Apple Inc.');

// Create pass structure
$structure = new Structure();

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

// Set pass structure
$pass->setStructure($structure);

// Add barcode
$barcode = new Barcode('PKBarcodeFormatQR', 'barcodeMessage');
$pass->setBarcode($barcode);

// Create pass factory instance
$factory = new PassFactory('PASS-TYPE-IDENTIFIER', 'TEAM-IDENTIFIER', 'ORGANIZATION-NAME', '/path/to/p12/certificate', 'P12-PASSWORD', '/path/to/wwdr/certificate');
$factory->setOutputPath('/path/to/output/path');
$factory->package($pass);
```

## Requirements
* PHP 5.3+
* [zip](http://php.net/manual/en/book.zip.php)
* [OpenSSL](http://www.php.net/manual/en/book.openssl.php)

<sub>PHP-Passbook depends on [JMS/Serializer](http://jmsyst.com/libs/serializer/master) library for pass serialization.</sub>

## Requesting Certificates

### P12 Certificate & Pass Type ID
1. Logon to [iOS Provisioning portal](https://developer.apple.com/ios/manage/passtypeids/index.action "iOS Provisioning portal") and go to Identifiers > Pass Type IDs
2. Follow the instructions to create a new Pass Type ID and download .cer file to your computer (Download button is under Settings)
3. Open downloaded file to add it into Keychain Access
4. Locate the certificate in Keychain Access and export it in .p12 format

### WWDR Certificate
Apple’s World Wide Developer Relations (WWDR) certificate is available from Apple at <http://developer.apple.com/certificationauthority/AppleWWDRCA.cer>. You will have to add this to your Keychain Access and export it in .pem format to use it with the library. The WWDR certificate links your development certificate to Apple, completing the trust chain for your application.

## Reporting an issue or a feature request
Issues and feature requests related to this library are tracked in the Github issue tracker: https://github.com/eymengunay/php-passbook/issues

## See also
[PassbookBundle](https://github.com/eymengunay/PassbookBundle): PHP-Passbook library integration for Symfony2
