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
     * Set image context
     * @param boolean
     */
    public function setContext($context);

    /**
     * Get image context
     * @param string
     */
    public function getContext();

    /**
     * Sets image is retina
     * @param boolean
     */
    public function setIsRetina($isRetina);

    /**
     * Returns image is retina
     * @param boolean
     */
    public function isRetina();
}
