<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Structure;
use Passbook\Pass\Field;
use PHPUnit\Framework\TestCase;

class StructureTest extends TestCase
{
    public function testStructure()
    {
        $structure = new Structure();

        $structure->addHeaderField(new Field('balance', '13.50 USD'));
        $structure->addBackField(new Field('publisher', 'Passbook Limited'));

        $actual = $structure->toArray();
        $expected = [
            "headerFields" => [
                ["key" => "balance", "value" => "13.50 USD"],
            ],
            "backFields" => [
                ["key" => "publisher", "value" => "Passbook Limited"]
            ]
        ];

        $this->assertEquals($expected, $actual);
    }
}