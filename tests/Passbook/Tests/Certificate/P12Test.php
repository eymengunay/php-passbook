<?php

namespace Passbook\Tests\Pass;

use Passbook\Certificate\P12;

class P12Test extends \PHPUnit_Framework_TestCase
{
    public function testP12()
    {
        $p12 = new P12(__DIR__.'/../../../dummy.p12', '123456');

        $this->assertEquals($p12->getPassword(), '123456');
    }
}