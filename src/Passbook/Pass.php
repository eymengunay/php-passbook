<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook;

use DateTime;
use Passbook\Pass\BarcodeInterface;
use Passbook\Pass\BeaconInterface;
use Passbook\Pass\NfcInterface;
use Passbook\Pass\ImageInterface;
use Passbook\Pass\LocalizationInterface;
use Passbook\Pass\LocationInterface;
use Passbook\Pass\Structure;
use Passbook\Pass\StructureInterface;

/**
 * Pass
 *
 * @author Eymen Gunay <eymen@egunay.com>
 * @author Sotaro Omura <http://omoon.org>
 * @author Dzamir <https://github.com/Dzamir>
 */
class Pass implements PassInterface
{
    /**
     * Serial number that uniquely identifies the pass.
     * No two passes with the same pass type identifier
     * may have the same serial number.
     *
     * @var string
     */
    protected $serialNumber;

    /**
     * Brief description of the pass,
     * used by the iOS accessibility technologies.
     *
     * @var string
     */
    protected $description;

    /**
     * Version of the file format.
     * The value must be 1.
     *
     * @var int
     */
    protected $formatVersion = 1;

    /**
     * Pass type
     *
     * @var string
     */
    protected $type;

    /**
     * Pass structure
     *
     * @var StructureInterface
     */
    protected $structure;

    /**
     * Pass images
     *
     * @var ImageInterface[]
     */
    protected $images = [];

    /**
     * Beacons where the pass is relevant.
     *
     * @var array
     */
    protected $beacons = [];

    /**
     * NFC where the pass is relevant.
     *
     * @var NfcInterface[]
     */
    protected $nfc = [];

    /**
     * A list of iTunes Store item identifiers (also known as Adam IDs) for the
     * associated apps.
     *
     * Only one item in the list is used—the first item identifier for an app
     * compatible with the current device. If the app is not installed, the
     * link opens the App Store and shows the app. If the app is already
     * installed, the link launches the app.
     *
     * @var int[]
     */
    protected $associatedStoreIdentifiers = [];

    /**
     * Locations where the pass is relevant.
     * For example, the location of your store.
     *
     * @var array
     */
    protected $locations = [];

    /**
     * List of localizations
     *
     * @var LocalizationInterface[]
     */
    protected $localizations = [];

    /**
     * Date and time when the pass becomes relevant.
     * For example, the start time of a movie.
     *
     * @var DateTime
     */
    protected $relevantDate;

    /**
     * Maximum distance in meters from a relevant latitude and longitude that
     * the pass is relevant. This number is compared to the pass’s default
     * distance and the smaller value is used.
     * Available in iOS 7.0.
     * @var int
     */
    protected $maxDistance;

    /**
     * Barcodes available to be displayed of iOS 9 and later. The system uses
     * the first valid barcode in the array.
     * @var BarcodeInterface[]
     */
    protected $barcodes = [];

    /**
     * Barcode to be displayed for iOS 8 and earlier.
     * @var BarcodeInterface
     */
    protected $barcode;

    /**
     * Background color of the pass, specified as an CSS-style RGB triple.
     *
     * @var string rgb(23, 187, 82)
     */
    protected $backgroundColor;

    /**
     * Foreground color of the pass, specified as a CSS-style RGB triple.
     *
     * @var string rgb(100, 10, 110)
     */
    protected $foregroundColor;

    /**
     * Identifier used to group related passes.
     * If a grouping identifier is specified, passes with the same style, pass type identifier,
     * and grouping identifier are displayed as a group. Otherwise, passes are grouped automatically.
     *
     * @var string
     */
    protected $groupingIdentifier;

    /**
     * Color of the label text, specified as a CSS-style RGB triple.
     *
     * @var string rgb(255, 255, 255)
     */
    protected $labelColor;

    /**
     * Text displayed next to the logo on the pass.
     *
     * @var string
     */
    protected $logoText;

    /**
     * If true, the strip image is displayed without a shine effect.
     *
     * @var string The default value is false
     */
    protected $suppressStripShine;

    /**
     * The authentication token to use with the web service.
     * The token must be 16 characters or longer.
     *
     * @var string
     */
    protected $authenticationToken;

    /**
     * The URL of a web service that conforms to the API described in Passbook Web Service Reference.
     * http://developer.apple.com/library/ios/documentation/PassKit/Reference/PassKit_WebService/WebService.html#//apple_ref/doc/uid/TP40011988
     *
     * @var string
     */
    protected $webServiceURL;

    /**
     * Pass type identifier
     *
     * @var string
     */
    protected $passTypeIdentifier;

    /**
     * Team identifier
     *
     * @var string
     */
    protected $teamIdentifier;

    /**
     * Organization name
     *
     * @var string
     */
    protected $organizationName;

    /**
     * Date and time when the pass expires.
     *
     * @var DateTime
     */
    protected $expirationDate;

    /**
     * Indicates that the pass is void—for example, a one time use coupon that has been redeemed. The default value is
     * false.
     *
     * @var boolean
     */
    protected $voided;

    /**
     *
     * A URL to be passed to the associated app when launching it.
     * The app receives this URL in the application:didFinishLaunchingWithOptions: and application:handleOpenURL:
     * methods of its app delegate. If this key is present, the associatedStoreIdentifiers key must also be present.
     *
     * @var string
     */
    protected $appLaunchURL;

    /**
     * Pass userInfo
     *
     * @var mixed
     */
    protected $userInfo;

    /**
     *
     * Flag to decide if the pass can be shared or not.
     *
     * @var bool
     *
     */
    protected bool $sharingProhibited = false;

    public function __construct($serialNumber, $description)
    {
        // Required
        $this->setSerialNumber($serialNumber);
        $this->setDescription($description);
    }

    public function toArray()
    {
        $array = [];

        // Structure
        if ($this->getStructure()) {
            $array[$this->getType()] = $this->getStructure()->toArray();
        }

        $properties = [
            'serialNumber',
            'description',
            'formatVersion',
            'beacons',
            'nfc',
            'locations',
            'maxDistance',
            'relevantDate',
            'barcode',
            'barcodes',
            'backgroundColor',
            'foregroundColor',
            'groupingIdentifier',
            'labelColor',
            'logoText',
            'suppressStripShine',
            'authenticationToken',
            'webServiceURL',
            'passTypeIdentifier',
            'teamIdentifier',
            'organizationName',
            'expirationDate',
            'voided',
            'appLaunchURL',
            'associatedStoreIdentifiers',
            'userInfo',
            'sharingProhibited'
        ];
        foreach ($properties as $property) {
            $method = 'is' . ucfirst($property);
            if (!method_exists($this, $method)) {
                $method = 'get' . ucfirst($property);
            }
            $val = $this->$method();
            if ($val instanceof DateTime) {
                // Date
                $array[$property] = $val->format('c');
            } elseif (is_object($val)) {
                // Object
                /* @var ArrayableInterface $val */
                $array[$property] = $val->toArray();
            } elseif (is_scalar($val)) {
                // Scalar
                $array[$property] = $val;
            } elseif (is_array($val)) {
                // Array
                foreach ($val as $k => $v) {
                    if (is_object($v)) {
                        /* @var ArrayableInterface $v */
                        $array[$property][$k] = $v->toArray();
                    } else {
                        $array[$property][$k] = $v;
                    }
                }
            }
        }
        if ($this->getAssociatedStoreIdentifiers()) {
            $array['associatedStoreIdentifiers'] = $this->getAssociatedStoreIdentifiers();
        }

        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = strval($serialNumber);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormatVersion()
    {
        return $this->formatVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function setFormatVersion($formatVersion)
    {
        $this->formatVersion = $formatVersion;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setStructure(StructureInterface $structure)
    {
        $this->structure = $structure;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStructure()
    {
        return $this->structure;
    }

    /**
     * {@inheritdoc}
     */
    public function addImage(ImageInterface $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * {@inheritdoc}
     */
    public function addLocalization(LocalizationInterface $localization)
    {
        $this->localizations[] = $localization;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocalizations()
    {
        return $this->localizations;
    }

    /**
     * {@inheritdoc}
     */
    public function addAssociatedStoreIdentifier($associatedStoreIdentifier)
    {
        $this->associatedStoreIdentifiers[] = $associatedStoreIdentifier;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAssociatedStoreIdentifiers()
    {
        return $this->associatedStoreIdentifiers;
    }

    /**
     * {@inheritdoc}
     */
    public function addLocation(LocationInterface $location)
    {
        $this->locations[] = $location;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * {@inheritdoc}
     */
    public function addBeacon(BeaconInterface $beacon)
    {
        $this->beacons[] = $beacon;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBeacons()
    {
        return $this->beacons;
    }

    /**
     * {@inheritdoc}
     */
    public function addNfc(NfcInterface $nfc)
    {
        $this->nfc[] = $nfc;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNfc()
    {
        return $this->nfc;
    }

    /**
     * {@inheritdoc}
     */
    public function setRelevantDate(DateTime $relevantDate)
    {
        $this->relevantDate = $relevantDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRelevantDate()
    {
        return $this->relevantDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setMaxDistance($maxDistance)
    {
        $this->maxDistance = $maxDistance;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxDistance()
    {
        return $this->maxDistance;
    }

    /**
     * {@inheritdoc}
     */
    public function setBarcode(BarcodeInterface $barcode)
    {
        $this->barcode = $barcode;
        array_unshift($this->barcodes, $barcode);

        return $this;
    }

    /**
     * @deprecated please use addNfc() instead.
     */
    public function setNfc(array $nfc)
    {
        $this->nfc = $nfc;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * {@inheritdoc}
     */
    public function addBarcode(BarcodeInterface $barcode)
    {
        $this->barcodes[] = $barcode;

        if (empty($this->barcode)) {
            $this->barcode = $barcode;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBarcodes()
    {
        return $this->barcodes;
    }

    /**
     * {@inheritdoc}
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * {@inheritdoc}
     */
    public function setForegroundColor($foregroundColor)
    {
        $this->foregroundColor = $foregroundColor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getForegroundColor()
    {
        return $this->foregroundColor;
    }

    /**
     * {@inheritdoc}
     */
    public function setGroupingIdentifier($groupingIdentifier)
    {
        $this->groupingIdentifier = $groupingIdentifier;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroupingIdentifier()
    {
        return $this->groupingIdentifier;
    }

    /**
     * {@inheritdoc}
     */
    public function setLabelColor($labelColor)
    {
        $this->labelColor = $labelColor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabelColor()
    {
        return $this->labelColor;
    }

    /**
     * {@inheritdoc}
     */
    public function setLogoText($logoText)
    {
        $this->logoText = $logoText;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogoText()
    {
        return $this->logoText;
    }

    /**
     * {@inheritdoc}
     */
    public function setSuppressStripShine($suppressStripShine)
    {
        $this->suppressStripShine = $suppressStripShine;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSuppressStripShine()
    {
        return $this->suppressStripShine;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthenticationToken($authenticationToken)
    {
        $this->authenticationToken = $authenticationToken;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthenticationToken()
    {
        return (string) $this->authenticationToken;
    }

    /**
     * {@inheritdoc}
     */
    public function setWebServiceURL($webServiceURL)
    {
        $this->webServiceURL = $webServiceURL;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWebServiceURL()
    {
        return $this->webServiceURL;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassTypeIdentifier($passTypeIdentifier)
    {
        $this->passTypeIdentifier = $passTypeIdentifier;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassTypeIdentifier()
    {
        return $this->passTypeIdentifier;
    }

    /**
     * {@inheritdoc}
     */
    public function setTeamIdentifier($teamIdentifier)
    {
        $this->teamIdentifier = $teamIdentifier;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTeamIdentifier()
    {
        return $this->teamIdentifier;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrganizationName($organizationName)
    {
        $this->organizationName = $organizationName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrganizationName()
    {
        return $this->organizationName;
    }

    /**
     * {@inheritdoc}
     */
    public function setExpirationDate(DateTime $expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setVoided($voided)
    {
        $this->voided = $voided;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVoided()
    {
        return $this->voided;
    }

    /**
     * {@inheritdoc}
     */
    public function setAppLaunchURL($appLaunchURL)
    {
        $this->appLaunchURL = $appLaunchURL;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppLaunchURL()
    {
        return $this->appLaunchURL;
    }

    /**
     * {@inheritdoc}
     */
    public function setUserInfo($userInfo)
    {
        $this->userInfo = $userInfo;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserInfo()
    {
        return $this->userInfo;
    }

    public function setSharingProhibited(bool $value): self
    {
        $this->sharingProhibited = $value;

        return $this;
    }

    public function getSharingProhibited(): bool
    {
        return $this->sharingProhibited;
    }
}
