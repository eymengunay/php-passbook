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
     * Available starting with iOS 9.
     * @var string
     */
    const TYPE_CODE_128 = 'PKBarcodeFormatCode128';

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
     * Text encoding that is used to convert the message
     * from the string representation to a data representation
     * to render the barcode. The value is typically iso-8859-1,
     * but you may use another encoding that is supported by
     * your barcode scanning infrastructure.
     * @var string
     */
    protected $messageEncoding;

    /**
     * Text displayed near the barcode. For example,
     * a human-readable version of the barcode data
     * in case the barcode doesn’t scan.
     * @var string
     */
    protected $altText;

    public function __construct($format, $message, $messageEncoding = 'iso-8859-1')
    {
        // Required
        $this->setMessage($message);
        $this->format = $format;
        $this->messageEncoding = $messageEncoding;
    }

    public function toArray()
    {
        $array = array(
            'format' => $this->getFormat(),
            'message' => $this->getMessage(),
            'messageEncoding' => $this->getMessageEncoding()
        );

        if ($this->getAltText()) {
            $array['altText'] = $this->getAltText();
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
        $this->message = strval($message);

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
        $this->altText = strval($altText);

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
