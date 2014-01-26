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
 * DateField
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class DateField extends Field implements DateFieldInterface
{
    public function __construct($key, \DateTime $value)
    {
        // Required
        $this->key   = $key;
        $this->value = $value;
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['value'] = $this->getValue()->format('c');

        return $array;
    }
}
