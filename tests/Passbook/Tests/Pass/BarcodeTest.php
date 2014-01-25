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
        ;

        $this->assertEquals($barcode->getFormat(), Barcode::TYPE_PDF_417);
        $this->assertEquals($barcode->getMessage(), 'hello');
        $array = $barcode->toArray();
    }
}