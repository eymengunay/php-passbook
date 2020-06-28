<?php

namespace Passbook\Tests\Certificate;

use Passbook\Certificate\WWDR;
use Passbook\Exception\FileNotFoundException;
use PHPUnit\Framework\TestCase;

class WWDRTest extends TestCase
{
    public function testWWDR()
    {
        $wwdr = new WWDR(__DIR__.'/../../../cert/wwdr.pem');
        $this->assertInstanceOf(WWDR::class, $wwdr);
    }

    public function testWWDRException()
    {
        $this->expectException(FileNotFoundException::class);
        new WWDR(__DIR__.'/non-existing-file');
    }
}