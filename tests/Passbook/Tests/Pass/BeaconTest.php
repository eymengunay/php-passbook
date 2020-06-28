<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Beacon;
use PHPUnit\Framework\TestCase;

class BeaconTest extends TestCase
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

        $expected = [
            'proximityUUID' => 'abcdef01-2345-6789-abcd-ef0123456789',
            'major' => 1,
            'minor' => 2,
            'relevantText' => 'relevant'
        ];

        $this->assertEquals($expected, $beacon->toArray());
    }
}