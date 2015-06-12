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

use Passbook\ArrayableInterface;

/**
 * BeaconInterface
 *
 * @author Sotaro Omura <http://omoon.org>
 */
interface BeaconInterface extends ArrayableInterface
{
    /**
     * Sets proximity UUID
     *
     * @param string
     */
    public function setProximityUUID($uuid);

    /**
     * Gets proximity UUID
     *
     * @return string
     */
    public function getProximityUUID();

    /**
     * Sets major
     *
     * @param integer
     */
    public function setMajor($major);

    /**
     * Gets major
     *
     * @return integer
     */
    public function getMajor();

    /**
     * Sets minor
     *
     * @param integer
     */
    public function setMinor($minor);

    /**
     * Gets minor
     *
     * @return integer
     */
    public function getMinor();

    /**
     * Gets relevant text
     *
     * @return string
     */
    public function getRelevantText();

    /**
     * Sets relevant text
     *
     * @param string
     */
    public function setRelevantText($relevantText);

}

