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
use Passbook\Exception\FileException;

/**
 * PassFactory - Creates .pkpass files
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class PassFactory
{
    /**
     * change
     * @var string
     */
    protected $passTypeIdentifier;

    /**
     * change
     * @var string
     */
    protected $teamIdentifier;

    /**
     * change
     * @var string
     */
    protected $organizationName;

    public function __construct($passTypeIdentifier, $teamIdentifier, $organizationName)
    {
        // Require
        $this->passTypeIdentifier = $passTypeIdentifier;
        $this->teamIdentifier     = $teamIdentifier;
        $this->organizationName   = $organizationName;
    }

    /**
     * Create .pkpass
     *
     * @param  Pass $pass
     * @return SplFileInfo real path to generated file
     */
    public function create(Pass $pass)
    {
        return 'not yet ready';
    }
}