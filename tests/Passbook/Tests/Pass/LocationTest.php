<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Location;

class LocationTest extends \PHPUnit_Framework_TestCase
{
    public function testBarcode()
    {
        $location = new Location(0, 0);

        $location
            ->setAltitude(100)
            ->setRelevantText('text')
        ;

        $this->assertEquals($location->getLatitude(), 0);
        $this->assertEquals($location->getLongitude(), 0);
        $array = $location->toArray();
    }
}