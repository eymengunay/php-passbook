<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Location;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testBarcode()
    {
        $location = new Location(0, 0);

        $location
            ->setAltitude(100)
            ->setRelevantText('text')
        ;

        $this->assertEquals(0, $location->getLatitude());
        $this->assertEquals(0, $location->getLongitude());

        $expected = [
            'latitude' => 0,
            'longitude' => 0,
            'altitude' => 100,
            'relevantText' => 'text'
        ];

        $this->assertEquals($expected, $location->toArray());
    }
}
