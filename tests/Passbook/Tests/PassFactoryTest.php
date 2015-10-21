<?php

namespace Passbook\Tests;

use Passbook\Pass;
use Passbook\PassFactory;
use Passbook\Type\EventTicket;
use Passbook\Pass\Field;
use Passbook\Pass\Barcode;
use Passbook\Pass\Image;
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

        // Create an event ticket
        $pass = new EventTicket(time(), "The Beat Goes On");
        $pass->setBackgroundColor('rgb(60, 65, 76)');
        $pass->setLogoText('Apple Inc.');

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

        // Add icon image
        $icon = new Image(__DIR__.'/../../img/icon.png', 'icon');
        $pass->addImage($icon);

        // Set pass structure
        $pass->setStructure($structure);

        // Add barcode
        $barcode = new Barcode(Barcode::TYPE_QR, 'barcodeMessage');
        $pass->setBarcode($barcode);

        $this->factory->setOutputPath(__DIR__.'/../../../www/passes');
        $file = $this->factory->package($pass);
        $this->assertInstanceOf('SplFileObject', $file);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPackagePassWithoutSerialNumberThrowsException()
    {
        $pass = new Pass('', 'pass without a serial number');

        $this->factory->setOutputPath('/tmp');
        $this->factory->package($pass);
    }

    public function testRequiredInformationInPassNotOverwrittenByFactory()
    {
        $passOrganizationName = 'organization name in pass';
        $passTeamIdentifier = 'team identifier in pass';
        $passPassTypeIdentifier = 'pass type identifier in pass';

        $pass = new Pass('serial number', 'description');
        $pass->setOrganizationName($passOrganizationName);
        $pass->setTeamIdentifier($passTeamIdentifier);
        $pass->setPassTypeIdentifier($passPassTypeIdentifier);

        $this->factory->setOutputPath('/tmp');
        $this->factory->setOverwrite(true);
        $this->factory->setSkipSignature(true);
        $this->factory->package($pass);

        self::assertEquals($passOrganizationName, $pass->getOrganizationName());
        self::assertEquals($passTeamIdentifier, $pass->getTeamIdentifier());
        self::assertEquals($passPassTypeIdentifier, $pass->getPassTypeIdentifier());
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        if (getenv('PASSBOOK_TEST_P12') && 
            getenv('PASSBOOK_TEST_P12_PASS') && 
            getenv('PASSBOOK_TEST_WWDR') && 
            getenv('PASSBOOK_TEST_TYPE_ID') && 
            getenv('PASSBOOK_TEST_TEAM_ID') && 
            getenv('PASSBOOK_TEST_ORG_NAME')) {

            $p12File = getenv('PASSBOOK_TEST_P12');
            $p12Pass = getenv('PASSBOOK_TEST_P12_PASS');
            $wwdrFile = getenv('PASSBOOK_TEST_WWDR');

            $passTypeIdentifier = getenv('PASSBOOK_TEST_TYPE_ID');
            $teamIdentifier = getenv('PASSBOOK_TEST_TEAM_ID');
            $organizationName = getenv('PASSBOOK_TEST_ORG_NAME');

            $this->factory = new PassFactory($passTypeIdentifier, $teamIdentifier, $organizationName, $p12File, $p12Pass, $wwdrFile);
        } else {
            $p12File = __DIR__.'/../../cert/dummy.p12';
            $p12Pass = '123456';
            $wwdrFile = __DIR__.'/../../cert/dummy.wwdr';
            $this->skipPackageTest = true;

            $this->factory = new PassFactory('pass-type-identifier', 'team-identifier', 'organization-name', $p12File, $p12Pass, $wwdrFile);
        }
    }
}
