<?php

namespace Passbook\Exception;

/**
 * Thrown when validation of a pass fails.
 */
class PassInvalidException extends \RuntimeException
{
    /**
     * Construct a PassInvalidException either with or without an array of errors.
     *
     * @param string[]|null $errors
     */
    public function __construct(array $errors = null)
    {
        $this->errors = $errors ? $errors : array();
    }

    /**
     * Returns the errors with the pass.
     *
     * @return string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
