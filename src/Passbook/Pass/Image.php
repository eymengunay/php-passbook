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

use Passbook\Exception\FileException;
use Passbook\Exception\FileNotFoundException;

/**
 * Image
 *
 * Must be one of the following values:
 * background - The image displayed as the background of the front of the pass.
 * footer - The image displayed on the front of the pass near the barcode.
 * icon - The pass’s icon. This is displayed in notifications and in emails that have a pass attached, and on the lock screen.
 * logo - The image displayed on the front of the pass in the top left.
 * strip - The image displayed behind the primary fields on the front of the pass.
 * thumbnail - An additional image displayed on the front of the pass. For example, on a membership card, the thumbnail could be used to a picture of the cardholder.
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class Image extends \SplFileObject implements ImageInterface
{
    /**
     * Image type. Must be one of the following values:
     * thumbnail, icon, background, logo, footer, strip
     * @var [type]
     */
    protected $type;

    /**
     * @var bool
     */
    protected $isRetina;

    public function __construct($filename, $type)
    {
        // Pass image type
        $this->$type = $type;
        // Call parent
        parent::__construct($filename);
    }

    /**
     * {@inheritdoc}
     */
    public function setIsRetina($isRetina)
    {
        $this->isRetina = $isRetina;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIsRetina()
    {
        return $this->isRetina;
    }
}