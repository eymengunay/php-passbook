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
     * This means, for example, the file name of high resolution versions of the image ends with @2x.png/@3x.png.
     * @var integer
     */
    protected $density;

    /**
     * Force "png" extension in case of dynamic conversion of the file, i.e. by CDN.
     *
     * @var bool
     */
    protected $forceExtension;

    public function __construct($filename, $context, $forceExtension = false)
    {
        parent::__construct($filename);

        $this->context = $context;
        $this->forceExtension = $forceExtension;
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
    public function setDensity($density)
    {
        $this->density = $density;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDensity()
    {
        return $this->density;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtension()
    {
        if ($this->forceExtension) {
            return 'png';
        }

        // Image pathname can be URL not only local file location
        return pathinfo(parse_url($this->getPathname(), PHP_URL_PATH), PATHINFO_EXTENSION);
    }
}
