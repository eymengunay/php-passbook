<?php

namespace Passbook\Tests\Exception;

use Passbook\Exception\PassInvalidException;

class PassInvalidExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testNewExceptionWithoutErrorsArray()
    {
        $exception = new PassInvalidException();

        self::assertTrue(is_array($exception->getErrors()));
        self::assertEmpty($exception->getErrors());
    }

    public function testNewExceptionWithErrorsArray()
    {
        $errors = array('error 1', 'error 2');
        $exception = new PassInvalidException($errors);

        self::assertTrue(is_array($exception->getErrors()));
        self::assertEquals($errors, $exception->getErrors());
    }

}
