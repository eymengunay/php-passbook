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
 * P12 certificate file
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class P12 extends Certificate
{
    /**
     * @param string $filename P12 certificate filename
     * @param string $password P12 certificate password
     */
    public function __construct(
        string $filename,
        private readonly string $password
    ) {
        parent::__construct($filename);
    }

    /**
     * @var string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
