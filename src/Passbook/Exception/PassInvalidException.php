<?php

namespace Passbook\Exception;

/**
 * Thrown when validation of a pass fails.
 */
class PassInvalidException extends \RuntimeException
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * Construct a PassInvalidException either with or without an array of errors.
     *
     * @param string        $message
     * @param string[]|null $errors
     */
    public function __construct($message = '', array $errors = null)
    {
        parent::__construct($message);
        $this->errors = $errors ? $errors : [];
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
