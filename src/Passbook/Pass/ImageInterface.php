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
 * ImageInterface
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
interface ImageInterface
{
    /**
     * Sets image is retina
     *
     * @param bool
     */
    public function setIsRetina($isRetina);

    /**
     * Returns image is retina
     *
     * @param string
     */
    public function getIsRetina();
}