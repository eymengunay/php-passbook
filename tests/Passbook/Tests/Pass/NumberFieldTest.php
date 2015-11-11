<?php

namespace Passbook\Tests\Pass;


use Passbook\Pass\NumberField;

class NumberFieldTest extends \PHPUnit_Framework_TestCase
{
    public function testValueIsNumber()
    {
        $field = new NumberField('price', '12.34');
        self::assertInternalType('float', $field->getValue());

        $field = new NumberField('price', '12');
        self::assertInternalType('int', $field->getValue());
    }

}
