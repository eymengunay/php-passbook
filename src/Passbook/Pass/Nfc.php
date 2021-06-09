<?php

/*
 * This file is part of the Passbook package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Pass;

/**
 * NFC
 */
class Nfc implements NfcInterface
{
    /**
     * NFC message
     * @var string
     */
    protected $message = '';

    /**
     * Encryption Public Key
     * @var string
     */
    protected $encryptionPublicKey = '';

    public function __construct($message, $encryptionPublicKey)
    {
        $this->setMessage($message);
        $this->setEncryptionPublicKey($encryptionPublicKey);
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
    public function setEncryptionPublicKey($encryptionPublicKey)
    {
        $this->encryptionPublicKey = $encryptionPublicKey;
        return $this;
    }

    public function toArray()
    {
        $array = [
            'message' => $this->getMessage(),
            'encryptionPublicKey' => $this->getEncryptionPublicKey()
        ];
        return $array;
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
    public function getEncryptionPublicKey()
    {
        return $this->encryptionPublicKey;
    }
}

