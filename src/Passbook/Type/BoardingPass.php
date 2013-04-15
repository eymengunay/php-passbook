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
 * BoardingPass
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class BoardingPass extends Pass
{
    /**
     * Pass type
     * @Exclude
     * @var string
     */
    protected $type = 'boardingPass';

    /**
     * Pass structure
     * @SerializedName(value="boardingPass")
     * @var Structure
     */
    protected $structure;

    /**
     * Type of transit. Must be one of the following values:
     * PKTransitTypeAir, PKTransitTypeBoat, PKTransitTypeBus, PKTransitTypeGeneric,PKTransitTypeTrain
     * @var string
     */
    protected $transitType;

    public function __construct($serialNumber, $name, $description, $transitType)
    {
        // Required for boarding passes; otherwise not allowed
        $this->$transitType = $transitType;
        // Call parent
        parent::__construct($serialNumber, $name, $description);
    }
}