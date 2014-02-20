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

use Passbook\Exception\FileNotFoundException;

/**
 * Abstract certificate file
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
abstract class Certificate extends \SplFileObject implements CertificateInterface
{
    public function __construct($filename)
    {
        try {
            parent::__construct($filename);
        } catch (\RuntimeException $e) {
            throw new FileNotFoundException($filename);
        }
    }
}
