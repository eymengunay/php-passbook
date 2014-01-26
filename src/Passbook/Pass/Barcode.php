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
     * @var string
     */
    const TYPE_QR = 'PKBarcodeFormatQR';

    /**
     * @var string
     */
    const TYPE_PDF_417 = 'PKBarcodeFormatPDF417';

    /**
     * @var string
     */
    const TYPE_AZTEC = 'PKBarcodeFormatAztec';

    /**
     * Barcode format. Must be one of the following values:
     * PKBarcodeFormatQR, PKBarcodeFormatPDF417, PKBarcodeFormatAztec.
     * @var string
     */
    protected $format;

    /**
     * Message or payload to be displayed as a barcode.
     * @var string
     */
    protected $message;

    /**
     * Message or payload to be displayed as a barcode.
     * @var string
     */
    protected $messageEncoding;

    /**
     * Text encoding that is used to convert the message from the
     * string representation to a data representation to render the barcode.
     * @var string
     */
    protected $altText;

    public function __construct($format, $message, $messageEncoding = 'iso-8859-1')
    {
        // Required
        $this->format          = $format;
        $this->message         = $message;
        $this->messageEncoding = $messageEncoding;
    }

    public function toArray()
    {
        $array = array(
            'format' => $this->getFormat(),
            'message' => $this->getMessage(),
            'messageEncoding' => $this->getMessageEncoding()
        );

        if ($altText = $this->getAltText()) {
            $array['altText'] = $altText;
        }

        return $array;
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
