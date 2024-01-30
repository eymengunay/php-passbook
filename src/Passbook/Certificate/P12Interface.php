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
 * P12Interface
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
interface P12Interface
{
    /**
     * Returns the absolute path to the certificate file
     *
     * @return string
     */
    public function getRealPath();

    /**
     * Returns p12 password
     *
     * @return string
     */
    public function getPassword();

    /**
     * Sets p12 password
     *
     * @param string $password
     */
    public function setPassword($password);
}
