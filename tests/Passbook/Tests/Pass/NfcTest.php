<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Nfc;
use PHPUnit\Framework\TestCase;

class NfcTest extends TestCase
{

    /**
     * @return void
     */
    public function testNfc()
    {
        $nfc = new Nfc('message', 'encryptionPublicKey', true);

        $this->assertEquals('message', $nfc->getMessage());
        $this->assertEquals('encryptionPublicKey', $nfc->getEncryptionPublicKey());
        $this->assertEquals(true, $nfc->getRequiresAuthentication());

        $nfc
            ->setMessage('hello')
            ->setEncryptionPublicKey('publicKey')
            ->setRequiresAuthentication(false)
        ;

        $this->assertEquals('hello', $nfc->getMessage());
        $this->assertEquals('publicKey', $nfc->getEncryptionPublicKey());
        $this->assertEquals(false, $nfc->getRequiresAuthentication());

        $array = $nfc->toArray();
        $this->assertArrayHasKey('message', $array);
        $this->assertArrayHasKey('encryptionPublicKey', $array);
        $this->assertArrayHasKey('requiresAuthentication', $array);
    }
}