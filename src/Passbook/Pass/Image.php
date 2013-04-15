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

use JMS\Serializer\Annotation\SerializedName;

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
     * Image context. Must be one of the following values:
     * thumbnail, icon, background, logo, footer, strip
     * @var string
     */
    protected $context;

    /**
     * All of the pass’s images are loaded using standard UIImage image-loading methods.
     * This means, for example, the file name of high resolution version of the image ends with @2x.png.
     * @SerializedName(value="isRetina")
     * @var bool
     */
    protected $isRetina;

    public function __construct($filename, $context)
    {
        // Call parent
        parent::__construct($filename);
        // Pass image context
        $this->setContext($context);
    }

    /**
     * {@inheritdoc}
     */
    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return $this->context;
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