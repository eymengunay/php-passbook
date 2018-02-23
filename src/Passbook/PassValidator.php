<?php

namespace Passbook;

use Passbook\Pass\Barcode;
use Passbook\Pass\Beacon;
use Passbook\Pass\Location;

/**
 * Validates the contents of a pass
 *
 * This attempts to find errors with a pass that would prevent it from working
 * properly with Apple Wallet. Passes with errors often just fail to load and
 * do not provide any feedback as to the error. Additionally, some issues (such
 * as a pass not having an icon) are not well documented and potentially
 * difficult to identify. This class aims to help identify and prevent these
 * issues.
 */
class PassValidator implements PassValidatorInterface
{
    private $errors;

    const DESCRIPTION_REQUIRED = 'description is required and cannot be blank';
    const FORMAT_VERSION_REQUIRED = 'formatVersion is required and must be 1';
    const ORGANIZATION_NAME_REQUIRED = 'organizationName is required and cannot be blank';
    const PASS_TYPE_IDENTIFIER_REQUIRED = 'passTypeIdentifier is required and cannot be blank';
    const SERIAL_NUMBER_REQUIRED = 'serialNumber is required and cannot be blank';
    const TEAM_IDENTIFIER_REQUIRED = 'teamIdentifier is required and cannot be blank';
    const ICON_REQUIRED = 'pass must have an icon image';
    const BARCODE_FORMAT_INVALID = 'barcode format is invalid';
    const BARCODE_MESSAGE_INVALID = 'barcode message is invalid; must be a string';
    const LOCATION_LATITUDE_REQUIRED = 'location latitude is required';
    const LOCATION_LONGITUDE_REQUIRED = 'location longitude is required';
    const LOCATION_LATITUDE_INVALID = 'location latitude is invalid; must be numeric';
    const LOCATION_LONGITUDE_INVALID = 'location longitude is invalid; must be numeric';
    const LOCATION_ALTITUDE_INVALID = 'location altitude is invalid; must be numeric';
    const BEACON_PROXIMITY_UUID_REQUIRED = 'beacon proximityUUID is required';
    const BEACON_MAJOR_INVALID = 'beacon major is invalid; must be 16-bit unsigned integer';
    const BEACON_MINOR_INVALID = 'beacon minor is invalid; must be 16-bit unsigned integer';
    const WEB_SERVICE_URL_INVALID = 'webServiceURL is invalid; must start with https (or http for development)';
    const WEB_SERVICE_AUTHENTICATION_TOKEN_REQUIRED = 'authenticationToken required with webServiceURL and cannot be blank';
    const WEB_SERVICE_AUTHENTICATION_TOKEN_INVALID = 'authenticationToken is invalid; must be at least 16 characters';
    const ASSOCIATED_STORE_IDENTIFIER_INVALID = 'associatedStoreIdentifiers is invalid; must be an integer';
    const ASSOCIATED_STORE_IDENTIFIER_REQUIRED = 'appLaunchURL is required when associatedStoreIdentifiers is present';
    const IMAGE_TYPE_INVALID = 'image files must be PNG format';
    const GROUPING_IDENTITY_INVALID = 'the grouping identity may only be used on boarding pass and event ticket types';

    /**
     * {@inheritdoc}
     */
    public function validate(PassInterface $pass)
    {
        $this->errors = array();

        $this->validateRequiredFields($pass);
        $this->validateBeaconKeys($pass);
        $this->validateLocationKeys($pass);
        $this->validateBarcodeKeys($pass);
        $this->validateWebServiceKeys($pass);
        $this->validateIcon($pass);
        $this->validateImageType($pass);
        $this->validateAssociatedStoreIdentifiers($pass);
        $this->validateGroupingIdentity($pass);

        return count($this->errors) === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrors()
    {
        return $this->errors;
    }

    private function validateRequiredFields(PassInterface $pass)
    {
        if ($this->isBlankOrNull($pass->getDescription())) {
            $this->addError(self::DESCRIPTION_REQUIRED);
        }

        if ($pass->getFormatVersion() !== 1) {
            $this->addError(self::FORMAT_VERSION_REQUIRED);
        }

        if ($this->isBlankOrNull($pass->getOrganizationName())) {
            $this->addError(self::ORGANIZATION_NAME_REQUIRED);
        }

        if ($this->isBlankOrNull($pass->getPassTypeIdentifier())) {
            $this->addError(self::PASS_TYPE_IDENTIFIER_REQUIRED);
        }

        if ($this->isBlankOrNull($pass->getSerialNumber())) {
            $this->addError(self::SERIAL_NUMBER_REQUIRED);
        }

        if ($this->isBlankOrNull($pass->getTeamIdentifier())) {
            $this->addError(self::TEAM_IDENTIFIER_REQUIRED);
        }
    }

    private function validateBeaconKeys(PassInterface $pass)
    {
        $beacons = $pass->getBeacons();

        foreach ($beacons as $beacon) {
            $this->validateBeacon($beacon);
        }
    }

    private function validateBeacon(Beacon $beacon)
    {
        if ($this->isBlankOrNull($beacon->getProximityUUID())) {
            $this->addError(self::BEACON_PROXIMITY_UUID_REQUIRED);
        }

        if (null !== $beacon->getMajor()) {
            if (!is_int($beacon->getMajor()) || $beacon->getMajor() < 0 || $beacon->getMajor() > 65535) {
                $this->addError(self::BEACON_MAJOR_INVALID);
            }
        }

        if (null !== $beacon->getMinor()) {
            if (!is_int($beacon->getMinor()) || $beacon->getMinor() < 0 || $beacon->getMinor() > 65535) {
                $this->addError(self::BEACON_MINOR_INVALID);
            }
        }
    }

    private function validateLocationKeys(PassInterface $pass)
    {
        $locations = $pass->getLocations();

        foreach ($locations as $location) {
            $this->validateLocation($location);
        }
    }

    private function validateLocation(Location $location)
    {
        if ($this->isBlankOrNull($location->getLatitude())) {
            $this->addError(self::LOCATION_LATITUDE_REQUIRED);
        }

        if (!is_numeric($location->getLatitude())) {
            $this->addError(self::LOCATION_LATITUDE_INVALID);
        }

        if ($this->isBlankOrNull($location->getLongitude())) {
            $this->addError(self::LOCATION_LONGITUDE_REQUIRED);
        }

        if (!is_numeric($location->getLongitude())) {
            $this->addError(self::LOCATION_LONGITUDE_INVALID);
        }

        if (!is_numeric($location->getAltitude()) && null !== $location->getAltitude()) {
            $this->addError(self::LOCATION_ALTITUDE_INVALID);
        }
    }

    private function validateBarcodeKeys(PassInterface $pass)
    {
        $validBarcodeFormats = array(Barcode::TYPE_QR, Barcode::TYPE_AZTEC, Barcode::TYPE_PDF_417, Barcode::TYPE_CODE_128);

        $barcode = $pass->getBarcode();

        if (!$barcode) {
            return;
        }

        if (!in_array($barcode->getFormat(), $validBarcodeFormats)) {
            $this->addError(self::BARCODE_FORMAT_INVALID);
        }

        if (!is_string($barcode->getMessage())) {
            $this->addError(self::BARCODE_MESSAGE_INVALID);
        }
    }

    private function validateWebServiceKeys(PassInterface $pass)
    {
        if (null === $pass->getWebServiceURL()) {
            return;
        }

        if (strpos($pass->getWebServiceURL(), 'http') !== 0) {
            $this->addError(self::WEB_SERVICE_URL_INVALID);
        }

        if ($this->isBlankOrNull($pass->getAuthenticationToken())) {
            $this->addError(self::WEB_SERVICE_AUTHENTICATION_TOKEN_REQUIRED);
        }

        if (strlen($pass->getAuthenticationToken()) < 16) {
            $this->addError(self::WEB_SERVICE_AUTHENTICATION_TOKEN_INVALID);
        }
    }

    private function validateIcon(PassInterface $pass)
    {
        foreach ($pass->getImages() as $image) {
            if ($image->getContext() === 'icon') {
                return;
            }
        }

        $this->addError(self::ICON_REQUIRED);
    }

    private function validateImageType(PassInterface $pass)
    {
        foreach ($pass->getImages() as $image) {
            if ('png' !== strtolower($image->getExtension())) {
                $this->addError(self::IMAGE_TYPE_INVALID);
            }
        }
    }

    private function validateAssociatedStoreIdentifiers(PassInterface $pass)
    {
        //appLaunchURL

        $associatedStoreIdentifiers = $pass->getAssociatedStoreIdentifiers();

        if (null !== $pass->getAppLaunchURL() && count($associatedStoreIdentifiers) == 0) {
            $this->addError(self::ASSOCIATED_STORE_IDENTIFIER_REQUIRED);
        }


        foreach ($associatedStoreIdentifiers as $associatedStoreIdentifier) {
            if (!is_int($associatedStoreIdentifier)) {
                $this->addError(self::ASSOCIATED_STORE_IDENTIFIER_INVALID);

                return;
            }
        }
    }

    private function validateGroupingIdentity(PassInterface $pass)
    {
        if (null !== $pass->getGroupingIdentifier() && !in_array($pass->getType(), ['boardingPass', 'eventTicket'])) {
            $this->addError(self::GROUPING_IDENTITY_INVALID);

            return;
        }
    }

    private function isBlankOrNull($text)
    {
        return '' === $text || null === $text;
    }

    private function addError($string)
    {
        $this->errors[] = $string;
    }

}
