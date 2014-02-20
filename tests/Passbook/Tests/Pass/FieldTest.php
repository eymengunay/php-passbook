<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Field;
use Passbook\Pass\DateField;
use Passbook\Pass\NumberField;

class FieldTest extends \PHPUnit_Framework_TestCase
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
        $field = new DateField('key', new \DateTime('2014-01-01 00:00:00 UTC'));

        $array = $field->toArray();
        $this->assertArrayHasKey('value', $array);
        $this->assertEquals('2014-01-01T00:00:00+00:00', $array['value']);
    }

	public function testNumberField()
	{
		$field = new NumberField('key', 'val');
		$field
			->setNumberStyle(NumberField::PKNumberStyleDecimal)
			->setCurrencyCode('EUR')
		;

		$array = $field->toArray();
		$this->assertArrayHasKey('currencyCode', $array);
	}
}