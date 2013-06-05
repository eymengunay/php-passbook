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

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\AccessType;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Exclude;
use Passbook\Pass\Structure;
use Passbook\Pass\Location;
use Passbook\Pass\Barcode;
use Passbook\Pass\Image;

/**
 * Pass
 *
 * @ExclusionPolicy("none")
 * @author Eymen Gunay <eymen@egunay.com>
 */
class Pass implements PassInterface
{
    /**
     * Serial number that uniquely identifies the pass.
     * No two passes with the same pass type identifier
     * may have the same serial number.
     * @SerializedName(value="serialNumber")
     * @var string
     */
    protected $serialNumber;

    /**
     * Brief description of the pass,
     * used by the iOS accessibility technologies.
     * @var string
     */
    protected $description;

    /**
     * Version of the file format.
     * The value must be 1.
     * @SerializedName(value="formatVersion")
     * @var int
     */
    protected $formatVersion = 1;

    /**
     * Pass type
     * @Exclude
     * @var string
     */
    protected $type;

    /**
     * Pass structure
     * @var Structure
     */
    protected $structure;

    /**
     * Pass images
     * @Accessor(setter="addImage")
     * @Exclude
     * @var string
     */
    protected $images = array();

    /**
     * A list of iTunes Store item identifiers
     * (also known as Adam IDs) for the associated apps.
     * @Accessor(setter="addAssociatedStoreIdentifiers")
     * @Exclude
     * @var array array of numbers
     */
    protected $associatedStoreIdentifiers = array();

    /**
     * Locations where the pass is relevant.
     * For example, the location of your store.
     * @Accessor(setter="addLocation")
     * @Exclude
     * @var array
     */
    protected $locations = array();

    /**
     * Date and time when the pass becomes relevant.
     * For example, the start time of a movie.
     * @SerializedName(value="relevantDate")
     * @var string W3C date
     */
    protected $relevantDate;

    /**
     * Date and time when the pass becomes relevant.
     * For example, the start time of a movie.
     * @var Barcode
     */
    protected $barcode;

    /**
     * Background color of the pass, specified as an CSS-style RGB triple.
     * @SerializedName(value="backgroundColor")
     * @var string rgb(23, 187, 82)
     */
    protected $backgroundColor;

    /**
     * Foreground color of the pass, specified as a CSS-style RGB triple.
     * @SerializedName(value="foregroundColor")
     * @var string rgb(100, 10, 110)
     */
    protected $foregroundColor;

    /**
     * Color of the label text, specified as a CSS-style RGB triple.
     * @SerializedName(value="labelColor")
     * @var string rgb(255, 255, 255)
     */
    protected $labelColor;

    /**
     * Text displayed next to the logo on the pass.
     * @SerializedName(value="logoText")
     * @var string
     */
    protected $logoText;

    /**
     * If true, the strip image is displayed without a shine effect.
     * @SerializedName(value="suppressStripShine")
     * @var string The default value is false
     */
    protected $suppressStripShine;

    /**
     * The authentication token to use with the web service.
     * The token must be 16 characters or longer.
     * @SerializedName(value="authenticationToken")
     * @var string
     */
    protected $authenticationToken;

    /**
     * The URL of a web service that conforms to the API described in Passbook Web Service Reference.
     * http://developer.apple.com/library/ios/documentation/PassKit/Reference/PassKit_WebService/WebService.html#//apple_ref/doc/uid/TP40011988
     * @SerializedName(value="webServiceUrl")
     * @var string
     */
    protected $webServiceURL;

    /**
     * Pass type identifier
     * @SerializedName(value="passTypeIdentifier")
     * @var string
     */
    protected $passTypeIdentifier;

    /**
     * Team identifier
     * @SerializedName(value="teamIdentifier")
     * @var string
     */
    protected $teamIdentifier;

    /**
     * Organization name
     * @SerializedName(value="organizationName")
     * @var string
     */
    protected $organizationName;

    public function __construct($serialNumber, $description)
    {
        // Required
        $this->serialNumber = $serialNumber;
        $this->description  = $description;
    }

    /**
     * {@inheritdoc}
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;
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
    }

    /**
     * {@inheritdoc}
     */
    public function setStructure($structure)
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
    public function addImage(Image $image)
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
    public function addLocation(Location $location)
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
    public function setRelevantDate($relevantDate)
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
    public function setBarcode(Barcode $barcode)
    {
        $this->barcode = $barcode;
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
        return $this->authenticationToken;
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
}