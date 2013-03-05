<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Pass;

/**
 * Location
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class Location implements LocationInterface
{
    /**
     * Altitude, in meters, of the location.
     * @var float
     */
    protected $altitude;

    /**
     * Latitude, in degrees, of the location.
     * @var float
     */
    protected $latitude;

    /**
     * Longitude, in degrees, of the location.
     * @var float
     */
    protected $longitude;

    /**
     * Text displayed on the lock screen when the pass is currently relevant.
     * For example, a description of the nearby location such as
     * “Store nearby on 1st and Main.”
     * @var string
     */
    protected $relevantText;

    public function __construct($latitude, $longitude)
    {
        // Required
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * {@inheritdoc}
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * {@inheritdoc}
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * {@inheritdoc}
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * {@inheritdoc}
     */
    public function setRelevantText($relevantText)
    {
        $this->relevantText = $relevantText;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRelevantText()
    {
        return $this->relevantText;
    }
}