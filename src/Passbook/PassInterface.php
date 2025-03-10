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

use Passbook\Pass\BarcodeInterface;
use Passbook\Pass\BeaconInterface;
use Passbook\Pass\NfcInterface;
use Passbook\Pass\Image;
use Passbook\Pass\ImageInterface;
use Passbook\Pass\LocalizationInterface;
use Passbook\Pass\LocationInterface;
use Passbook\Pass\StructureInterface;

/**
 * PassInterface
 *
 * @author Eymen Gunay <eymen@egunay.com>
 * @author Sotaro Omura <http://omoon.org>
 */
interface PassInterface extends ArrayableInterface
{
    public function __construct($serialNumber, $description);

    /**
     * {@inheritdoc}
     */
    public function setSerialNumber($serialNumber);

    /**
     * {@inheritdoc}
     */
    public function getSerialNumber();

    /**
     * {@inheritdoc}
     */
    public function setDescription($description);

    /**
     * {@inheritdoc}
     */
    public function getDescription();

    /**
     * {@inheritdoc}
     */
    public function getFormatVersion();

    /**
     * {@inheritdoc}
     */
    public function setFormatVersion($formatVersion);

    /**
     * {@inheritdoc}
     */
    public function getType();

    /**
     * {@inheritdoc}
     */
    public function setType($type);

    /**
     * {@inheritdoc}
     */
    public function setStructure(StructureInterface $structure);

    /**
     * {@inheritdoc}
     */
    public function getStructure();

    /**
     * {@inheritdoc}
     */
    public function addImage(ImageInterface $image);

    /**
     * @return ImageInterface[]
     */
    public function getImages();

    /**
     * {@inheritdoc}
     */
    public function addAssociatedStoreIdentifier($associatedStoreIdentifier);

    /**
     * {@inheritdoc}
     */
    public function getAssociatedStoreIdentifiers();

    /**
     * {@inheritdoc}
     */
    public function addLocation(LocationInterface $location);

    /**
     * {@inheritdoc}
     */
    public function getLocations();

    /**
     * {@inheritdoc}
     */
    public function addBeacon(BeaconInterface $beacon);

    /**
     * {@inheritdoc}
     */
    public function getBeacons();

    /**
     * {@inheritdoc}
     */
    public function addNfc(NfcInterface $nfc);

    /**
     * @return NfcInterface
     */
    public function getNfc();

    /**
     * {@inheritdoc}
     */
    public function setRelevantDate(\DateTime $relevantDate);

    /**
     * {@inheritdoc}
     */
    public function getRelevantDate();

    /**
     * {@inheritdoc}
     */
    public function setMaxDistance($maxDistance);

    /**
     * {@inheritdoc}
     */
    public function getMaxDistance();

    /**
     * @deprecated use addBarcode instead
     *
     * @param BarcodeInterface $barcode
     *
     * @return $this
     */
    public function setBarcode(BarcodeInterface $barcode);

    /**
     * @deprecated use getBarcodes instead
     *
     * @return BarcodeInterface
     */
    public function getBarcode();

    /**
     * @param BarcodeInterface $barcode - barcode to add to the pass
     *
     * @return $this
     */
    public function addBarcode(BarcodeInterface $barcode);

    /**
     * @return BarcodeInterface[]
     */
    public function getBarcodes();

    /**
     * {@inheritdoc}
     */
    public function setBackgroundColor($backgroundColor);

    /**
     * {@inheritdoc}
     */
    public function getBackgroundColor();

    /**
     * {@inheritdoc}
     */
    public function setForegroundColor($foregroundColor);

    /**
     * {@inheritdoc}
     */
    public function getForegroundColor();

    /**
     * {@inheritdoc}
     */
    public function setGroupingIdentifier($groupingIdentifier);

    /**
     * {@inheritdoc}
     */
    public function getGroupingIdentifier();

    /**
     * {@inheritdoc}
     */
    public function setLabelColor($labelColor);

    /**
     * {@inheritdoc}
     */
    public function getLabelColor();

    /**
     * {@inheritdoc}
     */
    public function setLogoText($logoText);

    /**
     * {@inheritdoc}
     */
    public function getLogoText();

    /**
     * {@inheritdoc}
     */
    public function setSharingProhibited(bool $sharingProhibited);

    /**
     * {@inheritdoc}
     */
    public function getSharingProhibited();

    /**
     * {@inheritdoc}
     */
    public function setSuppressStripShine($suppressStripShine);

    /**
     * {@inheritdoc}
     */
    public function getSuppressStripShine();

    /**
     * {@inheritdoc}
     */
    public function setAuthenticationToken($authenticationToken);

    /**
     * {@inheritdoc}
     */
    public function getAuthenticationToken();

    /**
     * {@inheritdoc}
     */
    public function setWebServiceURL($webServiceURL);

    /**
     * {@inheritdoc}
     */
    public function getWebServiceURL();

    /**
     * {@inheritdoc}
     */
    public function setPassTypeIdentifier($passTypeIdentifier);

    /**
     * {@inheritdoc}
     */
    public function getPassTypeIdentifier();

    /**
     * {@inheritdoc}
     */
    public function setTeamIdentifier($teamIdentifier);

    /**
     * {@inheritdoc}
     */
    public function getTeamIdentifier();

    /**
     * {@inheritdoc}
     */
    public function setOrganizationName($organizationName);

    /**
     * {@inheritdoc}
     */
    public function getOrganizationName();

    /**
     * @param LocalizationInterface $localization
     *
     * @return PassInterface
     */
    public function addLocalization(LocalizationInterface $localization);

    /**
     * @return LocalizationInterface[]
     */
    public function getLocalizations();

    /**
     * {@inheritdoc}
     */
    public function setAppLaunchURL($appLaunchURL);

    /**
     * {@inheritdoc}
     */
    public function getAppLaunchURL();

    /**
     * {@inheritdoc}
     */
    public function setUserInfo($userInfo);

    /**
     * {@inheritdoc}
     */
    public function getUserInfo();
}
