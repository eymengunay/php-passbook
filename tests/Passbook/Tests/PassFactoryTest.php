<?php

namespace Passbook\Tests;

use Passbook\Pass;
use Passbook\Pass\Localization;
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
        $pass = new EventTicket(time(), 'The Beat Goes On');
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

        $auxiliary = new Pass\NumberField('price', '12.34');
        $auxiliary->setLabel('Price');
        $auxiliary->setCurrencyCode('USD');
        $structure->addAuxiliaryField($auxiliary);

        // Add icon image
        $icon = new Image(__DIR__.'/../../img/icon.png', 'icon');
        $pass->addImage($icon);

        // Set pass structure
        $pass->setStructure($structure);

        // Add barcode
        $barcode = new Barcode(Barcode::TYPE_QR, 'barcodeMessage');
        $pass->setBarcode($barcode);

        // Add Localizations (this also tests zipping subdirectories)
        $englishText = array(
            'created_by' => 'Pass produced by php-passbook'
        );

        $spanishText = array(
            'created_by' => 'Pase producido por php-passbook'
        );
        
        $es = new Localization('es');
        $es->addStrings($spanishText);
        $pass->addLocalization($es);

        $en = new Localization('en');
        $en->addStrings($englishText);
        $pass->addLocalization($en);
        
        $field = new Field('exclusive_card', 'created_by');
        $structure->addBackField($field);
        
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
    
    //This is super lazy, just copied and pasted from above. Should clean up at some point...
    
    public function testRequiredInformationInPassNotOverwrittenByFactoryPlusSpecifyPassName()
    {
        $passOrganizationName = 'organization name in pass';
        $passTeamIdentifier = 'team identifier in pass';
        $passPassTypeIdentifier = 'pass type identifier in pass';

        $pass = new Pass('serial number', 'description', 'pass name');
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
        // The configuration for the PassFactory can set using environment
        // variables in your own phpunit.xml configuration file. Copy the
        // phpunit.xml.dist file to phpunit.xml. Uncomment the following lines
        // and add the values for your certificates and organization.
        //
        //<env name="PASSBOOK_TEST_P12" value="pass.com.example.testpass.p12" />
        //<env name="PASSBOOK_TEST_PASS" value="123456" />
        //<env name="PASSBOOK_TEST_WWDR" value="wwdr.pem" />
        //<env name="PASSBOOK_TEST_TYPE_ID" value="pass.com.example.testpass" />
        //<env name="PASSBOOK_TEST_TEAM_ID" value="ABCDE12345" />
        //<env name="PASSBOOK_TEST_ORG_NAME" value="Organization Name" />

        $p12File = getenv('PASSBOOK_TEST_P12') ?: __DIR__.'/../../cert/dummy.p12';
        $wwdrFile = getenv('PASSBOOK_TEST_WWDR') ?: __DIR__.'/../../cert/dummy.wwdr';
        $p12Password = getenv('PASSBOOK_TEST_P12_PASS') ?: '';
        $passTypeIdentifier = getenv('PASSBOOK_TEST_TYPE_ID') ?: 'pass-type-identifier';
        $teamIdentifier = getenv('PASSBOOK_TEST_TEAM_ID') ?: 'team-identifier';
        $organizationName = getenv('PASSBOOK_TEST_ORG_NAME') ?: 'organization-name';

        // We can't package without the certificates.
        $this->skipPackageTest = !getenv('PASSBOOK_TEST_P12') || !getenv('PASSBOOK_TEST_WWDR');

        $this->factory = new PassFactory($passTypeIdentifier, $teamIdentifier, $organizationName, $p12File, $p12Password, $wwdrFile);
    }
}
