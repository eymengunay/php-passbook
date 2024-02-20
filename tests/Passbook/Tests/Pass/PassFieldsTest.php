<?php

namespace Passbook\Tests\Pass;

use Passbook\Apple\PassFields;
use Passbook\Apple\Field;
use PHPUnit\Framework\TestCase;

class PassFieldsTest extends TestCase
{
    public function testpassFields()
    {
        $passFields = new PassFields();

        $passFields->addHeaderField(new Field('balance', '13.50 USD'));
        $passFields->addBackField(new Field('publisher', 'Passbook Limited'));

        $actual = $passFields->toArray();
        $expected = [
            'headerFields' => [
                ['key' => 'balance', 'value' => '13.50 USD'],
            ],
            'backFields' => [
                ['key' => 'publisher', 'value' => 'Passbook Limited']
            ]
        ];

        $this->assertEquals($expected, $actual);
    }
}
