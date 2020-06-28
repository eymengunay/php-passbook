<?php

namespace Passbook\Tests\Exception;

use Passbook\Exception\PassInvalidException;
use PHPUnit\Framework\TestCase;

class PassInvalidExceptionTest extends TestCase
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
        $exception = new PassInvalidException('', $errors);

        self::assertTrue(is_array($exception->getErrors()));
        self::assertEquals($errors, $exception->getErrors());
    }

    public function testNewExceptionWithMessageAndArray()
    {
        $errors = array('error 1', 'error 2');
        $exception = new PassInvalidException('Exception message', $errors);

        self::assertTrue(is_array($exception->getErrors()));
        self::assertEquals($errors, $exception->getErrors());
        self::assertSame('Exception message', $exception->getMessage());
    }

}
