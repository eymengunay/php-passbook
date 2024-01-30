<?php

namespace Passbook;

interface PassValidatorInterface
{
    /**
     * Performs validation of the pass.
     *
     * @param PassInterface $pass - the pass to be validated.
     *
     * @return bool - true if the pass passes validation, false otherwise
     */
    public function validate(PassInterface $pass);

    /**
     * Returns the errors found when validating the pass. When there are no
     * errors, an empty array is returned.
     *
     * @return string[]
     */
    public function getErrors();
}
