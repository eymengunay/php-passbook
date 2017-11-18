<?php

namespace Passbook\Tests;

use Passbook\Pass;
use Passbook\Pass\Barcode;
use Passbook\Pass\Beacon;
use Passbook\Pass\Image;
use Passbook\Pass\Location;
use Passbook\PassValidator;
use Passbook\Type\Generic;

class PassValidatorTest extends \PHPUnit_Framework_TestCase
{
    const SERIAL_NUMBER = '123';
    const DESCRIPTION = 'description';

    /**
     * @var Pass
     */
    private $pass;

    public function testPassWithoutDescription()
    {
        $this->assertFails(new Generic(self::SERIAL_NUMBER, ''), PassValidator::DESCRIPTION_REQUIRED);
        $this->assertFails(new Generic(self::SERIAL_NUMBER, null), PassValidator::DESCRIPTION_REQUIRED);
        $this->assertPasses(new Generic(self::SERIAL_NUMBER, '0'), PassValidator::DESCRIPTION_REQUIRED);
    }

    public function testPassWithoutSerialNumber()
    {
        $this->assertFails(new Generic('', self::DESCRIPTION), PassValidator::SERIAL_NUMBER_REQUIRED);
        $this->assertFails(new Generic(null, self::DESCRIPTION), PassValidator::SERIAL_NUMBER_REQUIRED);
        $this->assertPasses(new Generic('0', self::DESCRIPTION), PassValidator::SERIAL_NUMBER_REQUIRED);
    }

    public function testPassFormatVersion()
    {
        $this->assertPasses($this->pass, PassValidator::FORMAT_VERSION_REQUIRED);
        $this->pass->setFormatVersion('');
        $this->assertFails($this->pass, PassValidator::FORMAT_VERSION_REQUIRED);
        $this->pass->setFormatVersion(null);
        $this->assertFails($this->pass, PassValidator::FORMAT_VERSION_REQUIRED);
        $this->pass->setFormatVersion('0');
        $this->assertFails($this->pass, PassValidator::FORMAT_VERSION_REQUIRED);
    }

    public function testPassWithoutOrganizationName()
    {
        $this->pass->setOrganizationName('');
        $this->assertFails($this->pass, PassValidator::ORGANIZATION_NAME_REQUIRED);
        $this->pass->setOrganizationName(null);
        $this->assertFails($this->pass, PassValidator::ORGANIZATION_NAME_REQUIRED);
        $this->pass->setOrganizationName('0');
        $this->assertPasses($this->pass, PassValidator::ORGANIZATION_NAME_REQUIRED);
    }

    public function testPassWithoutPassTypeIdentifier()
    {
        $this->pass->setPassTypeIdentifier('');
        $this->assertFails($this->pass, PassValidator::PASS_TYPE_IDENTIFIER_REQUIRED);
        $this->pass->setPassTypeIdentifier(null);
        $this->assertFails($this->pass, PassValidator::PASS_TYPE_IDENTIFIER_REQUIRED);
        $this->pass->setPassTypeIdentifier('0');
        $this->assertPasses($this->pass, PassValidator::PASS_TYPE_IDENTIFIER_REQUIRED);
    }

    public function testPassWithoutTeamIdentifier()
    {
        $this->pass->setTeamIdentifier('');
        $this->assertFails($this->pass, PassValidator::TEAM_IDENTIFIER_REQUIRED);
        $this->pass->setTeamIdentifier(null);
        $this->assertFails($this->pass, PassValidator::TEAM_IDENTIFIER_REQUIRED);
        $this->pass->setTeamIdentifier('0');
        $this->assertPasses($this->pass, PassValidator::TEAM_IDENTIFIER_REQUIRED);
    }

    public function testPassBarcodeFormat()
    {
        // First test pass without barcode passes
        $this->assertPasses($this->pass, PassValidator::BARCODE_FORMAT_INVALID);
        $this->pass->setBarcode(new Barcode(Barcode::TYPE_CODE_128, 'message'));
        $this->assertPasses($this->pass, PassValidator::BARCODE_FORMAT_INVALID);

        $this->pass->setBarcode(new Barcode('', 'message'));
        $this->assertFails($this->pass, PassValidator::BARCODE_FORMAT_INVALID);
        $this->pass->setBarcode(new Barcode(null, 'message'));
        $this->assertFails($this->pass, PassValidator::BARCODE_FORMAT_INVALID);
        $this->pass->setBarcode(new Barcode('invalid format', 'message'));
        $this->assertFails($this->pass, PassValidator::BARCODE_FORMAT_INVALID);
    }

    public function testPassBarcodeMessage()
    {
        // Test first before barcode is added
        $this->assertPasses($this->pass, PassValidator::BARCODE_MESSAGE_INVALID);
        $this->pass->setBarcode(new Barcode(Barcode::TYPE_QR, 'message'));
        $this->assertPasses($this->pass, PassValidator::BARCODE_MESSAGE_INVALID);
        $this->pass->setBarcode(new Barcode(Barcode::TYPE_QR, ''));
        $this->assertPasses($this->pass, PassValidator::BARCODE_MESSAGE_INVALID);

        $this->pass->setBarcode(new Barcode('', null));
        $this->assertFails($this->pass, PassValidator::BARCODE_FORMAT_INVALID);
        $this->pass->setBarcode(new Barcode(null, 0));
        $this->assertFails($this->pass, PassValidator::BARCODE_FORMAT_INVALID);
        $this->pass->setBarcode(new Barcode(null, 123));
        $this->assertFails($this->pass, PassValidator::BARCODE_FORMAT_INVALID);
    }

    public function testPassLocation()
    {
        $this->assertPasses($this->pass, PassValidator::LOCATION_LONGITUDE_REQUIRED);
        $this->assertPasses($this->pass, PassValidator::LOCATION_LATITUDE_REQUIRED);
        $this->assertPasses($this->pass, PassValidator::LOCATION_ALTITUDE_INVALID);

        $location = new Location(0,0);
        $this->pass->addLocation($location);
        $this->assertPasses($this->pass, PassValidator::LOCATION_LONGITUDE_REQUIRED);
        $this->assertPasses($this->pass, PassValidator::LOCATION_LATITUDE_REQUIRED);
        $this->assertPasses($this->pass, PassValidator::LOCATION_ALTITUDE_INVALID);

        $location->setLatitude(null);
        $this->assertFails($this->pass, PassValidator::LOCATION_LATITUDE_REQUIRED);
        $location->setLatitude('');
        $this->assertFails($this->pass, PassValidator::LOCATION_LATITUDE_REQUIRED);
        $location->setLatitude('foo');
        $this->assertFails($this->pass, PassValidator::LOCATION_LATITUDE_INVALID);

        $location->setLatitude(0);
        $location->setLongitude(null);
        $this->assertFails($this->pass, PassValidator::LOCATION_LONGITUDE_REQUIRED);
        $location->setLongitude('');
        $this->assertFails($this->pass, PassValidator::LOCATION_LONGITUDE_REQUIRED);
        $location->setLongitude('foo');
        $this->assertFails($this->pass, PassValidator::LOCATION_LONGITUDE_INVALID);

        $location->setLongitude(0);
        $location->setAltitude(0);
        $this->assertPasses($this->pass, PassValidator::LOCATION_ALTITUDE_INVALID);

        $location->setAltitude('');
        $this->assertFails($this->pass, PassValidator::LOCATION_ALTITUDE_INVALID);
        $location->setAltitude('foo');
        $this->assertFails($this->pass, PassValidator::LOCATION_ALTITUDE_INVALID);
    }

    public function testPassBeacon()
    {
        $this->assertPasses($this->pass, PassValidator::BEACON_PROXIMITY_UUID_REQUIRED);
        $this->assertPasses($this->pass, PassValidator::BEACON_MAJOR_INVALID);
        $this->assertPasses($this->pass, PassValidator::BEACON_MINOR_INVALID);

        $beacon = new Beacon('2b4fcf51-4eaa-446d-b24e-4d1b437f3840');
        $this->pass->addBeacon($beacon);
        $this->assertPasses($this->pass, PassValidator::BEACON_PROXIMITY_UUID_REQUIRED);
        $this->assertPasses($this->pass, PassValidator::BEACON_MAJOR_INVALID);
        $this->assertPasses($this->pass, PassValidator::BEACON_MINOR_INVALID);

        $beacon->setMajor('');
        $this->assertFails($this->pass, PassValidator::BEACON_MAJOR_INVALID);
        $beacon->setMajor('foo');
        $this->assertFails($this->pass, PassValidator::BEACON_MAJOR_INVALID);
        $beacon->setMajor(-1);
        $this->assertFails($this->pass, PassValidator::BEACON_MAJOR_INVALID);
        $beacon->setMajor(65536);
        $this->assertFails($this->pass, PassValidator::BEACON_MAJOR_INVALID);

        $beacon->setMajor(0);
        $beacon->setMinor('');
        $this->assertFails($this->pass, PassValidator::BEACON_MINOR_INVALID);
        $beacon->setMinor('foo');
        $this->assertFails($this->pass, PassValidator::BEACON_MINOR_INVALID);
        $beacon->setMinor(-1);
        $this->assertFails($this->pass, PassValidator::BEACON_MINOR_INVALID);
        $beacon->setMinor(65536);
        $this->assertFails($this->pass, PassValidator::BEACON_MINOR_INVALID);
    }

    public function testWebServiceAuthenticationToken()
    {
        $this->assertPasses($this->pass, PassValidator::WEB_SERVICE_URL_INVALID);
        $this->assertPasses($this->pass, PassValidator::WEB_SERVICE_AUTHENTICATION_TOKEN_INVALID);

        $this->pass->setWebServiceURL('');
        $this->assertFails($this->pass, PassValidator::WEB_SERVICE_URL_INVALID);

        $this->pass->setWebServiceURL('https://example.com');
        $this->assertFails($this->pass, PassValidator::WEB_SERVICE_AUTHENTICATION_TOKEN_REQUIRED);

        $this->pass->setAuthenticationToken('1234567890abcde');
        $this->assertFails($this->pass, PassValidator::WEB_SERVICE_AUTHENTICATION_TOKEN_INVALID);
    }

    public function testPassWithoutIcon()
    {
        self::assertArrayNotHasKey('icon', $this->pass->getImages(), 'pass must not have an icon for test to be valid');
        $this->assertFails($this->pass, PassValidator::ICON_REQUIRED);

        $icon = new Image(__DIR__.'/../../img/icon.png', 'icon');
        $this->pass->addImage($icon);
        $this->assertPasses($this->pass, PassValidator::ICON_REQUIRED);
    }

    public function testPassAssociatedStoreIdentifiers()
    {
        $this->assertPasses($this->pass, PassValidator::ASSOCIATED_STORE_IDENTIFIER_INVALID);

        $this->pass->setAppLaunchURL('url');
        $this->assertFails($this->pass, PassValidator::ASSOCIATED_STORE_IDENTIFIER_REQUIRED);

        $this->pass->addAssociatedStoreIdentifier(123);
        $this->assertPasses($this->pass, PassValidator::ASSOCIATED_STORE_IDENTIFIER_INVALID);

        $this->pass->addAssociatedStoreIdentifier('not an integer');
        $this->assertFails($this->pass, PassValidator::ASSOCIATED_STORE_IDENTIFIER_INVALID);
    }

    public function testPassImageType()
    {
        $this->assertPasses($this->pass, PassValidator::IMAGE_TYPE_INVALID);

        $png = new Image(__DIR__ . '/../../img/icon.png', 'icon');
        $this->pass->addImage($png);
        $this->assertPasses($this->pass, PassValidator::IMAGE_TYPE_INVALID);

        $png = new Image(__DIR__ . '/../../img/icon2@2x.PNG', 'icon');
        $this->pass->addImage($png);
        $this->assertPasses($this->pass, PassValidator::IMAGE_TYPE_INVALID);

        $jpg = new Image(__DIR__ . '/../../img/icon.jpg', 'icon');
        $this->pass->addImage($jpg);
        $this->assertFails($this->pass, PassValidator::IMAGE_TYPE_INVALID);
    }

    public function testGroupingIdentity()
    {
        $this->pass->setType('boardingPass');
        $this->pass->setGroupingIdentifier('group1');
        $this->assertPasses($this->pass, PassValidator::GROUPING_IDENTITY_INVALID);

        $this->pass->setType('eventTicket');
        $this->pass->setGroupingIdentifier('group1');
        $this->assertPasses($this->pass, PassValidator::GROUPING_IDENTITY_INVALID);

        $this->pass->setType('coupon');
        $this->pass->setGroupingIdentifier('group1');
        $this->assertFails($this->pass, PassValidator::GROUPING_IDENTITY_INVALID);

        $this->pass->setType('storeCard');
        $this->pass->setGroupingIdentifier('group1');
        $this->assertFails($this->pass, PassValidator::GROUPING_IDENTITY_INVALID);
    }
    
    private function assertFails($pass, $expectedError)
    {
        $validator = new PassValidator();
        self::assertFalse($validator->validate($pass));
        self::assertContains($expectedError, $validator->getErrors());
    }

    private function assertPasses($pass, $unexpectedError)
    {
        $validator = new PassValidator();
        $validator->validate($pass);
        self::assertNotContains($unexpectedError, $validator->getErrors());
    }

    protected function setUp()
    {
        $this->pass = new Generic(self::SERIAL_NUMBER, self::DESCRIPTION);
    }
}
