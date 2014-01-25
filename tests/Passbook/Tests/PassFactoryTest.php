<?php

namespace Passbook\Tests;

use Passbook\PassFactory;
use Passbook\Type\Coupon;

class PassFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PassFactory
     */
    protected $factory;

    /**
     * @var Coupon
     */
    protected $coupon;

    /**
     * Factory
     */
    public function testFactory()
    {
        $this->factory->setOverwrite(true);
        $this->assertTrue($this->factory->isOverwrite());

        $this->factory->setOutputPath('/tmp');
        $this->assertEquals($this->factory->getOutputPath(), '/tmp');

        // $file = $this->factory->package($this->coupon);
        // $this->assertInstanceOf('SplFileObject', $file);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $p12File = __DIR__.'/../../dummy.p12';
        $p12Pass = '123456';
        $wwdrFile = 'http://developer.apple.com/certificationauthority/AppleWWDRCA.cer';

        $this->factory = new PassFactory('pass-type-identifier', 'team-identifier', 'organization-name', $p12File, $p12Pass, $wwdrFile);
        $this->coupon = new Coupon(uniqid(), 'Lorem ipsum');
    }
}
