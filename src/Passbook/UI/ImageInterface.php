<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\File;

use Passbook\Exception\FileException;
use Passbook\Exception\FileNotFoundException;

/**
 * ImageInterface
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
interface ImageInterface
{
	/**
     * Returns image type
     *
     * @return string
     */
    public function getType();

    /**
     * Sets image type
     *
     * @param string
     */
    public function setType($type);

    /**
     * Returns image is retina
     *
     * @param string
     */
    public function getIsRetina();

    /**
     * Sets image is retina
     *
     * @param bool
     */
    public function setIsRetina($isRetina);
}