<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function testImage()
    {
        $image = new Image(__DIR__.'/../../../img/icon.png', 'thumbnail');
        $image->setDensity(2);

        $this->assertEquals($image->getContext(), 'thumbnail');
        $this->assertEquals($image->getDensity(), 2);
    }

    public function testImage3x()
    {
        $image = new Image(__DIR__.'/../../../img/icon.png', 'thumbnail');
        $image->setDensity(3);

        $this->assertEquals('thumbnail', $image->getContext());
        $this->assertEquals(3, $image->getDensity());
    }
}
