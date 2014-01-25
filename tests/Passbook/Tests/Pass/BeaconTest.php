<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Beacon;

class BeaconTest extends \PHPUnit_Framework_TestCase
{
    public function testBeacon()
    {
        $beacon = new Beacon('abcdef01-2345-6789-abcd-ef0123456789');

        $beacon
            ->setMajor(1)
            ->setMinor(2)
            ->setRelevantText('relevant')
        ;

        $this->assertEquals($beacon->getMajor(), 1);
        $this->assertEquals($beacon->getMinor(), 2);
        $array = $beacon->toArray();
    }
}