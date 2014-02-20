<?php

namespace Passbook\Tests\Pass;

use Passbook\Certificate\P12;
use Passbook\Exception\FileNotFoundException;

class P12Test extends \PHPUnit_Framework_TestCase
{
    public function testP12()
    {
        $p12 = new P12(__DIR__.'/../../../cert/dummy.p12', '123456');

        $this->assertEquals($p12->getPassword(), '123456');
    }

    public function testP12Exception()
    {
        $this->setExpectedException('Passbook\Exception\FileNotFoundException');

        $wwdr = new P12(__DIR__.'/non-existing-file', '123456');
    }
}