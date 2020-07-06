<?php

namespace Passbook\Tests;

use Exception;
use InvalidArgumentException;
use Passbook\Exception\PassInvalidException;
use Passbook\Pass;
use Passbook\Pass\Localization;
use Passbook\PassFactory;
use Passbook\PassValidator;
use Passbook\Type\EventTicket;
use Passbook\Pass\Field;
use Passbook\Pass\Barcode;
use Passbook\Pass\Image;
use Passbook\Pass\Structure;
use PHPUnit\Framework\TestCase;

/**
 * Class PassFactoryTest
 * @package Passbook\Tests
 */
class PassFactoryTest extends TestCase
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
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // The PassFactory defaults can be overwritten by setting environment
        // variables or through phpunit configuration when testing.

        $p12File = getenv('P12_CERT_PATH') ?: __DIR__ . '/../../cert/pass.com.example.testpass.p12';
        $p12Pass = getenv('P12_CERT_PASS') ?: '123456';
        $wwdrFile = getenv('WWDR_CERT_PATH') ?: __DIR__ . '/../../cert/wwdr.pem';
        $passTypeIdentifier = getenv('PASS_TYPE_ID') ?: 'pass-type-identifier';
        $teamIdentifier = getenv('TEAM_ID') ?: 'team-identifier';
        $orgName = getenv('ORG_NAME') ?: 'organization-name';

        $this->factory = new PassFactory($passTypeIdentifier, $teamIdentifier, $orgName, $p12File, $p12Pass, $wwdrFile);
    }

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
     * @throws Exception
     */
    public function testFactoryPackage()
    {
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
        $icon = new Image(__DIR__ . '/../../img/icon.png', 'icon');
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

        if ($this->skipPackageTest) {
            $this->markTestIncomplete(
                'P12 and/or WWDR certificate(s) not found'
            );
        }

        $this->factory->setOutputPath(__DIR__ . '/../../../www/passes');
        $file = $this->factory->package($pass);
        $this->assertInstanceOf('SplFileObject', $file);
    }

    /**
     * @throws InvalidArgumentException|Exception
     */
    public function testPackagePassWithoutSerialNumberThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $pass = new Pass('', 'pass without a serial number');

        $this->factory->setOutputPath('/tmp');
        $this->factory->package($pass);
    }

    /**
     * @throws Exception
     */
    public function testRequiredInformationInPassNotOverwrittenByFactory()
    {
        $passOrganizationName = 'organization name in pass';
        $passTeamIdentifier = 'team identifier in pass';
        $passPassTypeIdentifier = 'pass type identifier in pass';

        $pass = new Pass('serial_number', 'description');
        $pass->setOrganizationName($passOrganizationName);
        $pass->setTeamIdentifier($passTeamIdentifier);
        $pass->setPassTypeIdentifier($passPassTypeIdentifier);

        // Icon is required
        $icon = new Image(__DIR__ . '/../../img/icon.png', 'icon');
        $pass->addImage($icon);

        $this->factory->setOutputPath('/tmp');
        $this->factory->setOverwrite(true);
        $this->factory->setSkipSignature(true);
        $this->factory->package($pass);

        self::assertEquals($passOrganizationName, $pass->getOrganizationName());
        self::assertEquals($passTeamIdentifier, $pass->getTeamIdentifier());
        self::assertEquals($passPassTypeIdentifier, $pass->getPassTypeIdentifier());
    }

    /**
     *
     */
    public function testNormalizedOutputPath()
    {
        $s = DIRECTORY_SEPARATOR;

        $this->factory->setOutputPath("path-ending-with-separator{$s}");
        self::assertEquals("path-ending-with-separator{$s}", $this->factory->getNormalizedOutputPath());

        $this->factory->setOutputPath("path-not-ending-with-separator");
        self::assertEquals("path-not-ending-with-separator{$s}", $this->factory->getNormalizedOutputPath());

        $this->factory->setOutputPath("path-ending-with-multiple-separators{$s}{$s}");
        self::assertEquals("path-ending-with-multiple-separators{$s}", $this->factory->getNormalizedOutputPath());
    }

    /**
     * @throws PassInvalidException|Exception
     */
    public function testPassThatFailsValidationThrowsException()
    {
        $this->expectException(PassInvalidException::class);
        $this->factory->setPassValidator(new PassValidator());

        $invalidPass = new Pass('serial number', 'description');
        $this->factory->package($invalidPass);
    }

    /**
     * @throws Exception
     */
    public function testSpecifyPassName()
    {
        // Make sure the file doesn't already exist as that would invalidate the test.
        if (file_exists('/tmp/passname.pkpass')) {
            unlink('/tmp/passname.pkpass');
        }

        $pass = new Pass('serial number', 'description');

        // Icon is required
        $icon = new Image(__DIR__ . '/../../img/icon.png', 'icon');
        $pass->addImage($icon);

        $this->factory->setOutputPath('/tmp');
        $this->factory->setSkipSignature(true);
        $this->factory->package($pass, 'pass name');

        self::assertTrue(file_exists('/tmp/passname.pkpass'));
    }
}
