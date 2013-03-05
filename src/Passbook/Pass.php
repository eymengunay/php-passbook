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

use Passbook\Pass\Location;
use Passbook\Pass\LocationInterface;
use Passbook\Pass\Barcode;
use Passbook\Pass\BarcodeInterface;

/**
 * Pass
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class Pass
{
    /**
     * Serial number that uniquely identifies the pass.
     * No two passes with the same pass type identifier
     * may have the same serial number.
     * @var string
     */
    protected $serialNumber;

    /**
     * Pass name
     * @var string
     */
    protected $name;

    /**
     * Brief description of the pass,
     * used by the iOS accessibility technologies.
     * @var string
     */
    protected $description;

    /**
     * Pass type
     * @var string
     */
    protected $type;

    /**
     * Version of the file format.
     * The value must be 1.
     * @var int
     */
    protected $formatVersion = 1;

    /**
     * Pass images
     * @var string
     */
    protected $images = array();

    /**
     * A list of iTunes Store item identifiers
     * (also known as Adam IDs) for the associated apps.
     * @var array array of numbers
     */
    protected $associatedStoreIdentifiers = array();

    /**
     * Locations where the pass is relevant.
     * For example, the location of your store.
     * @var array
     */
    protected $locations = array();

    /**
     * Date and time when the pass becomes relevant.
     * For example, the start time of a movie.
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
     * @var string rgb(23, 187, 82)
     */
    protected $backgroundColor;

    /**
     * Foreground color of the pass, specified as a CSS-style RGB triple.
     * @var string rgb(100, 10, 110)
     */
    protected $foregroundColor;

    /**
     * Color of the label text, specified as a CSS-style RGB triple.
     * @var string rgb(255, 255, 255)
     */
    protected $labelColor;

    /**
     * Text displayed next to the logo on the pass.
     * @var string
     */
    protected $logoText;

    /**
     * If true, the strip image is displayed without a shine effect.
     * @var string The default value is false
     */
    protected $suppressStripShine;

    /**
     * The authentication token to use with the web service.
     * The token must be 16 characters or longer.
     * @var string
     */
    protected $authenticationToken;

    /**
     * The URL of a web service that conforms to the API described in Passbook Web Service Reference.
     * http://developer.apple.com/library/ios/documentation/PassKit/Reference/PassKit_WebService/WebService.html#//apple_ref/doc/uid/TP40011988
     * @var string
     */
    protected $webServiceURL;

    public function __construct($serialNumber, $name, $description)
    {
        // Required
        $this->serialNumber = $serialNumber;
        $this->name         = $name;
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
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
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
    public function addImage(ImageInterface $image)
    {
        $this->image[] = $image;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return $this->image;
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
    public function setBarcode(BarcodeInterface $barcode)
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
}