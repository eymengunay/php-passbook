<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Image;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function testImage()
    {
        $image = new Image(__DIR__.'/../../../img/icon.png', 'thumbnail');
        $image->setIsRetina(true);

        $this->assertEquals($image->getContext(), 'thumbnail');
        $this->assertEquals($image->isRetina(), true);
    }
}