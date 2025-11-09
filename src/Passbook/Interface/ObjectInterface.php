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
 * This interface defines the methods common in all Google *Object.php objects.
 * It is manually injected in Walletobjects via a diff file after
 * Google APIs Client Generator runs.
 *
 * @author Razvan Grigore <razvan.grigore@vampirebyte.ro>
 */
interface ObjectInterface
{
    /**
     * Required. The unique identifier for an object. This ID must be unique
     * across all objects from an issuer. This value needs to follow the format
     * `issuerID.identifier` where `issuerID` is issued by Google and `identifier`
     * is chosen by you. The unique identifier can only include alphanumeric
     * characters, `.`, `_`, or `-`.
     *
     * @param string $id
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getId();

    /**
     * Required. The state of the object. This field is used to determine how an
     * object is displayed in the app. For example, an `inactive` object is moved
     * to the "Expired passes" section.
     *
     * Accepted values: STATE_UNSPECIFIED, ACTIVE, active, COMPLETED, completed,
     * EXPIRED, expired, INACTIVE, inactive
     */
    public function setState($state);

    /**
     * @return string
     */
    public function getState();

    /**
     * Required. The class associated with this object. The class must be of the
     * same type as this object, must already exist, and must be approved. Class
     * IDs should follow the format `issuerID.identifier` where `issuerID` is
     * issued by Google and `identifier` is chosen by you.
     *
     * @param string $classId
     */
    public function setClassId($classId);

    /**
     * @return string
     */
    public function getClassId();
}
