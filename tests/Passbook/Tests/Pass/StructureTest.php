<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\Structure;
use Passbook\Pass\Field;

class StructureTest extends \PHPUnit_Framework_TestCase
{
    public function testStructure()
    {
        $structure = new Structure(0, 0);

        $structure->addHeaderField(new Field('key', 'val'));
        $structure->addBackField(new Field('key', 'val'));

        $array = $structure->toArray();
    }
}