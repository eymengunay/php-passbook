<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\NumberField;
use PHPUnit\Framework\TestCase;

class NumberFieldTest extends TestCase
{
    public function testValueIsNumber()
    {
        $field = new NumberField('price', '12.34');
        $this->assertIsFloat($field->getValue());

        $field = new NumberField('price', '12');
        $this->assertIsInt($field->getValue());
    }
}
