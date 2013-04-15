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
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\SerializedName;

/**
 * StoreCard
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class StoreCard extends Pass
{
    /**
     * Pass type
     * @Exclude
     * @var string
     */
    protected $type = 'storeCard';

    /**
     * Pass structure
     * @SerializedName(value="storeCard")
     * @var Structure
     */
    protected $structure;
}