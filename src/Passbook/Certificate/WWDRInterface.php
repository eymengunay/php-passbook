<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Certificate;

/**
 * WWDRInterface
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
interface WWDRInterface
{
    /**
     * Returns the absolute path to the certificate file
     *
     * @return string
     */
    public function getRealPath();
}
