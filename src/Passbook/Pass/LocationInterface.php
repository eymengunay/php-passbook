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
 * LocationInterface
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
interface LocationInterface extends ArrayableInterface
{
    /**
     * Sets location altitude
     *
     * @param float $altitude
     */
    public function setAltitude($altitude);

    /**
     * Gets location altitude
     *
     * @return float
     */
    public function getAltitude();

    /**
     * Sets location latitude
     *
     * @param float $latitude
     */
    public function setLatitude($latitude);

    /**
     * Gets location latitude
     *
     * @return float
     */
    public function getLatitude();

    /**
     * Sets location longitude
     *
     * @param float $longitude
     */
    public function setLongitude($longitude);

    /**
     * Gets location longitude
     *
     * @return float
     */
    public function getLongitude();

    /**
     * Sets location relevant text
     *
     * @param string $relevantText
     */
    public function setRelevantText($relevantText);

    /**
     * Gets location relevant text
     *
     * @return string
     */
    public function getRelevantText();
}
