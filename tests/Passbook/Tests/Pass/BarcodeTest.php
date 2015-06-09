<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Barcode;

class BarcodeTest extends \PHPUnit_Framework_TestCase
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

        $this->assertEquals($barcode->getFormat(), Barcode::TYPE_PDF_417);
        $this->assertEquals($barcode->getMessage(), 'hello');
        $this->assertEquals($barcode->getAltText(), 'hello world');
        $array = $barcode->toArray();
    }

    public function testBarcodeMessageIsString()
    {
        $barcode = new Barcode(Barcode::TYPE_QR, 123);
        $barcode->setAltText(456);

        $this->assertInternalType('string', $barcode->getMessage());
        $this->assertInternalType('string', $barcode->getAltText());

        $barcodeDetails = $barcode->toArray();
        $this->assertInternalType('string', $barcodeDetails['message']);
        $this->assertInternalType('string', $barcodeDetails['altText']);

        $barcode->setMessage(789);
        $this->assertInternalType('string', $barcode->getMessage());

        $barcode->setMessage(null);
        $this->assertEquals('', $barcode->getMessage());
    }
}