<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook;

use Passbook\Certificate\P12;
use Passbook\Certificate\WWDR;

/**
 * PassFactory
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class PassFactory
{
    public function __construct($passTypeIdentifier, $teamIdentifier, $organizationName)
    {
        throw new \Exception("I didn't have time to finish this :)");
    }

    public function create(PassInterface $pass)
    {
    }
}