<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Type;

use Passbook\Pass;
use Passbook\Pass\Structure;

/**
 * Generic
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class Generic extends Pass
{
    /**
     * Pass type
     * @var string
     */
    protected $type = 'generic';

    /**
     * Pass structure
     * @var Structure
     */
    protected $structure;
}
