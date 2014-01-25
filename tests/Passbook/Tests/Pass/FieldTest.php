<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Field;

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
}