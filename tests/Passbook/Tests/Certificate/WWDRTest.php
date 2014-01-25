<?php

namespace Passbook\Tests\Pass;

use Passbook\Certificate\WWDR;

class WWDRTest extends \PHPUnit_Framework_TestCase
{
    public function testWWDR()
    {
        $wwdr = new WWDR(__DIR__.'/../../../dummy.wwdr');
    }
}