<?php

namespace Passbook\Tests\Pass;

use Passbook\Certificate\WWDR;
use Passbook\Exception\FileNotFoundException;

class WWDRTest extends \PHPUnit_Framework_TestCase
{
    public function testWWDR()
    {
        $wwdr = new WWDR(__DIR__.'/../../../cert/dummy.wwdr');
    }

    public function testWWDRException()
    {
        $this->setExpectedException('Passbook\Exception\FileNotFoundException');

        $wwdr = new WWDR(__DIR__.'/non-existing-file');
    }
}