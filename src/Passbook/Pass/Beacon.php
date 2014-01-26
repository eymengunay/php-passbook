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
 * Beacon
 *
 * @author Sotaro Omura <http://omoon.org>
 */
class Beacon implements BeaconInterface
{
    /**
     * Unique identifier of a Bluetooth Low Energy location beacon.
     * @var string
     */
    protected $proximityUUID;

    /**
     * Major identifier of a Bluetooth Low Energy location beacon.
     * @var integer
     */
    protected $major;

    /**
     * Minor identifier of a Bluetooth Low Energy location beacon.
     * @var integer
     */
    protected $minor;

    /**
     * Text displayed on the lock screen when the pass is currently relevant.
     * For example, a description of the nearby location such as
     * “Store nearby on 1st and Main.”
     * @var string
     */
    protected $relevantText;

    public function __construct($proximityUUID)
    {
        // Required
        $this->setProximityUUID($proximityUUID);
    }

    public function toArray()
    {
        $array = array(
            'proximityUUID' => $this->getProximityUUID()
        );

        if ($major = $this->getMajor()) {
            $array['major'] = $major;
        }

        if ($minor = $this->getMinor()) {
            $array['minor'] = $minor;
        }

        if ($relevantText = $this->getRelevantText()) {
            $array['relevantText'] = $relevantText;
        }

        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function setMajor($major)
    {
        $this->major = $major;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * {@inheritdoc}
     */
    public function setMinor($minor)
    {
        $this->minor = $minor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMinor()
    {
        return $this->minor;
    }

    /**
     * {@inheritdoc}
     */
    public function setProximityUUID($proximityUUID)
    {
        $this->proximityUUID = $proximityUUID;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProximityUUID()
    {
        return $this->proximityUUID;
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

