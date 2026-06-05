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
 * RelevantDateInterface
 *
 * @author Christian Freear <https://github.com/cfreear>
 */
interface RelevantDateInterface extends ArrayableInterface
{
    /**
     * Sets relevant date and time
     *
     * @param \DateTime $datetime
     */
    public function setDate($datetime);

    /**
     * Gets relevant date and time
     *
     * @return \DateTime
     */
    public function getDate();

    /**
     * Sets the pass relevancy interval end date
     *
     * @param \DateTime $datetime
     */
    public function setEndDate($datetime);

    /**
     * Gets the pass relevancy interval end date
     *
     * @return \DateTime
     */
    public function getEndDate();

    /**
     * Sets the pass relevancy interval start date
     *
     * @param \DateTime $datetime
     */
    public function setStartDate($datetime);

    /**
     * Gets the pass relevancy interval start date
     *
     * @return \DateTime
     */
    public function getStartDate();
}
