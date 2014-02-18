<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Field;
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