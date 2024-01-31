<?php

/*
 * This file is part of the Passbook package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Pass;

use Passbook\ArrayableInterface;

/**
 * NfcInterface
 */
interface NfcInterface extends ArrayableInterface
{
    /**
     * Sets NFC message
     *
     * @param string $message
     */
    public function setMessage($message);

    /**
     * Gets NFC message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Sets encryption Public Key
     *
     * @param string $encryptionPublicKey
     */
    public function setEncryptionPublicKey($encryptionPublicKey);

    /**
     * Gets encryptionPublicKey
     *
     * @return string
     */
    public function getEncryptionPublicKey();
}
