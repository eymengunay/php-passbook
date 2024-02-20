<?php

namespace Passbook\Tests\Pass;

use DateTime;
use Passbook\Apple\Field;
use Passbook\Apple\DateField;
use Passbook\Apple\NumberField;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{
    public function testField()
    {
        $field = new Field('key', 'val');
        $field
            ->setChangeMessage('change-message')
            ->setTextAlignment(Field::ALIGN_RIGHT)
        ;

        $array = $field->toArray();
        $this->assertArrayHasKey('key', $array);
    }

    public function testDateField()
    {
        $field = new DateField('key', new DateTime('2014-01-01 00:00:00 UTC'));

        $array = $field->toArray();
        $this->assertArrayHasKey('value', $array);
        $this->assertEquals('2014-01-01T00:00:00+00:00', $array['value']);
    }

    public function testNumberField()
    {
        $field = new NumberField('key', 0);
        $field
            ->setNumberStyle(NumberField::NUMBER_STYLE_DECIMAL)
            ->setCurrencyCode('EUR')
        ;

        $this->assertArrayHasKey('currencyCode', $field->toArray());
    }
}
