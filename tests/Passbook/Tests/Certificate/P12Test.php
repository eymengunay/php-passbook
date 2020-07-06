<?php

namespace Passbook\Tests\Certificate;

use Passbook\Certificate\P12;
use Passbook\Exception\FileNotFoundException;
use PHPUnit\Framework\TestCase;

class P12Test extends TestCase
{
    public function testP12()
    {
        $p12 = new P12(__DIR__.'/../../../cert/pass.com.example.testpass.p12', '123456');

        $this->assertEquals($p12->getPassword(), '123456');
    }

    public function testP12Exception()
    {
        $this->expectException(FileNotFoundException::class);
        new P12(__DIR__.'/non-existing-file', '123456');
    }
}