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

/**
 * BoardingPass
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class BoardingPass extends Pass
{
    /**
     * Pass type
     * @var string
     */
    protected $type = 'boardingPass';

    /**
     * Type of transit. Must be one of the following values:
     * PKTransitTypeAir, PKTransitTypeBoat, PKTransitTypeBus, PKTransitTypeGeneric, PKTransitTypeTrain
     * @var string
     */
    protected $transitType;

    /**
     * @var string
     */
    public const TYPE_AIR = 'PKTransitTypeAir';

    /**
     * @var string
     */
    public const TYPE_BOAT = 'PKTransitTypeBoat';

    /**
     * @var string
     */
    public const TYPE_BUS = 'PKTransitTypeBus';

    /**
     * @var string
     */
    public const TYPE_GENERIC = 'PKTransitTypeGeneric';

    /**
     * @var string
     */
    public const TYPE_TRAIN = 'PKTransitTypeTrain';

    /**
     * Class constructor
     *
     * @param string $serialNumber
     * @param string $description
     * @param string $transitType
     */
    public function __construct($serialNumber, $description, $transitType = self::TYPE_GENERIC)
    {
        // Required for boarding passes; otherwise not allowed
        $this->transitType = $transitType;
        // Call parent
        parent::__construct($serialNumber, $description);
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array[$this->getType()]['transitType'] = $this->transitType;

        return $array;
    }
}
