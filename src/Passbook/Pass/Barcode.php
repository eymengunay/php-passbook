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
 * Barcode
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class Barcode implements BarcodeInterface
{
    /**
     * Barcode format. Must be one of the following values:
     * PKBarcodeFormatQR, PKBarcodeFormatPDF417, PKBarcodeFormatAztec.
     * @var string
     */
    public $format;

    /**
     * Message or payload to be displayed as a barcode.
     * @var string
     */
    public $message;

    /**
     * Message or payload to be displayed as a barcode.
     * @var string
     */
    public $messageEncoding;

    /**
     * Text encoding that is used to convert the message from the
     * string representation to a data representation to render the barcode.
     * @var string
     */
    public $altText;

    public function __construct($format, $message, $messageEncoding = 'iso-8859-1')
    {
        // Required
        $this->format          = $format;
        $this->message         = $message;
        $this->messageEncoding = $messageEncoding;
    }

    /**
     * {@inheritdoc}
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessageEncoding($messageEncoding)
    {
        $this->messageEncoding = $messageEncoding;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessageEncoding()
    {
        return $this->messageEncoding;
    }

    /**
     * {@inheritdoc}
     */
    public function setAltText($altText)
    {
        $this->altText = $altText;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAltText()
    {
        return $this->altText;
    }
}