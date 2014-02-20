<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Certificate;

/**
 * P12 certificate file
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class P12 extends Certificate implements P12Interface
{
    /**
     * P12 certificate password
     * @var string
     */
    protected $password;

    public function __construct($filename, $password)
    {
        parent::__construct($filename);

        $this->setPassword($password);
    }

    /**
     * {@inheritdoc}
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }
}
