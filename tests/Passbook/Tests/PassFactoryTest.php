<?php

namespace Passbook\Tests;

use Passbook\PassFactory;
use Passbook\Type\EventTicket;
use Passbook\Pass\Field;
use Passbook\Pass\Barcode;
use Passbook\Pass\Location;
use Passbook\Pass\Structure;

class PassFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PassFactory
     */
    protected $factory;

    /**
     * @var boolean
     */
    private $skipPackageTest = false;

    /**
     * Factory methods
     */
    public function testFactoryMethods()
    {
        $this->factory->setOverwrite(true);
        $this->assertTrue($this->factory->isOverwrite());

        $this->factory->setOutputPath('/tmp');
        $this->assertEquals($this->factory->getOutputPath(), '/tmp');
    }

    /**
     * Factory package
     */
    public function testFactoryPackage()
    {
        if ($this->skipPackageTest) {
            $this->markTestSkipped(
                'P12 and/or WWDR certificate(s) not found'
            );
        }

        $eventTicket  = new EventTicket(uniqid(), 'Lorem ipsum');
        $eventTicket->setBackgroundColor('rgb(60, 65, 76)');
        $this->assertSame('rgb(60, 65, 76)', $eventTicket->getBackgroundColor());
        $eventTicket->setLogoText('Apple Inc.');
        $this->assertSame('Apple Inc.', $eventTicket->getLogoText());

        // Add location
        $location = new Location(59.33792, 18.06873);
        $eventTicket->addLocation($location);

        // Create pass structure
        $structure = new Structure();

        // Add primary field
        $primary = new Field('event', 'The Beat Goes On');
        $primary->setLabel('Event');
        $structure->addPrimaryField($primary);

        // Add secondary field
        $secondary = new Field('location', 'Moscone West');
        $secondary->setLabel('Location');
        $structure->addSecondaryField($secondary);

        // Add auxiliary field
        $auxiliary = new Field('datetime', '2013-04-15 @10:25');
        $auxiliary->setLabel('Date & Time');
        $structure->addAuxiliaryField($auxiliary);

        // Relevant date
        $eventTicket->setRelevantDate(new \DateTime());

        // Set pass structure
        $eventTicket->setStructure($structure);

        // Add barcode
        $barcode = new Barcode('PKBarcodeFormatQR', 'barcodeMessage');
        $eventTicket->setBarcode($barcode);

        $this->factory->setOutputPath(sys_get_temp_dir());
        $file = $this->factory->package($eventTicket);
        $this->assertInstanceOf('SplFileObject', $file);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        if (getenv('PASSBOOK_TEST_P12') && getenv('PASSBOOK_TEST_P12_PASS') && getenv('PASSBOOK_TEST_WWDR')) {
            $p12File = getenv('PASSBOOK_TEST_P12');
            $p12Pass = getenv('PASSBOOK_TEST_P12_PASS');
            $wwdrFile = getenv('PASSBOOK_TEST_WWDR');
        } else {
            $p12File = __DIR__.'/../../dummy.p12';
            $p12Pass = '123456';
            $wwdrFile = 'http://developer.apple.com/certificationauthority/AppleWWDRCA.cer';
            $this->skipPackageTest = true;
        }

        $this->factory = new PassFactory('pass-type-identifier', 'team-identifier', 'organization-name', $p12File, $p12Pass, $wwdrFile);
    }
}
