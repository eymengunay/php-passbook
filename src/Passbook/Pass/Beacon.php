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

use JMS\Serializer\Annotation\SerializedName;

/**
 * Beacon
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class Beacon implements BeaconInterface
{
    /**
     * Unique identifier of a Bluetooth Low Energy location beacon.
     * @SerializedName(value="proximityUUID")
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
     * @SerializedName(value="relevantText")
     * @var string
     */
    protected $relevantText;

    public function __construct($proximityUUID)
    {
        // Required
        $this->proximityUUID  = $proximityUUID;
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

