<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Interface;

/**
 * This interface defines the methods common in all Google *Class.php objects.
 * It is manually injected in Walletobjects via a diff file after
 * Google APIs Client Generator runs.
 *
 * @author Razvan Grigore <razvan.grigore@vampirebyte.ro>
 */
interface ClassInterface
{
    /**
     * Required. The unique identifier for a class. This ID must be unique across
     * all classes from an issuer. This value should follow the format issuer ID.
     * identifier where the former is issued by Google and latter is chosen by
     * you. Your unique identifier should only include alphanumeric characters,
     * '.', '_', or '-'.
     *
     * @param string $id
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getId();
}
