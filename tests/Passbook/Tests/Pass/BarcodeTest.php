<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Barcode;
use PHPUnit\Framework\TestCase;

class BarcodeTest extends TestCase
{
    public function testBarcode()
    {
        $barcode = new Barcode(Barcode::TYPE_QR, 'message');

        $barcode
            ->setFormat(Barcode::TYPE_PDF_417)
            ->setMessage('hello')
            ->setMessageEncoding('iso-8859-1')
            ->setAltText('hello world')
        ;

        $this->assertEquals(Barcode::TYPE_PDF_417, $barcode->getFormat());
        $this->assertEquals('hello', $barcode->getMessage());
        $this->assertEquals('hello world', $barcode->getAltText());
        $array = $barcode->toArray();
    }

    public function testBarcodeMessageIsString()
    {
        $barcode = new Barcode(Barcode::TYPE_QR, 123);
        $barcode->setAltText(456);

        $this->assertIsString($barcode->getMessage());
        $this->assertIsString($barcode->getAltText());

        $barcodeDetails = $barcode->toArray();
        $this->assertIsString($barcodeDetails['message']);
        $this->assertIsString($barcodeDetails['altText']);

        $barcode->setMessage(789);
        $this->assertIsString($barcode->getMessage());

        $barcode->setMessage(null);
        $this->assertEquals('', $barcode->getMessage());
    }
}