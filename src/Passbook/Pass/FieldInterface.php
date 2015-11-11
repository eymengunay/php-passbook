<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Pass;

use Passbook\ArrayableInterface;

/**
 * FieldInterface
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
interface FieldInterface extends ArrayableInterface
{
    /**
     * Sets change message
     *
     * @param string
     */
    public function setChangeMessage($changeMessage);

    /**
     * Returns change message
     *
     * @param string
     */
    public function getChangeMessage();

    /**
     * Sets key
     *
     * @param string
     */
    public function setKey($key);

    /**
     * Returns key
     *
     * @param string
     */
    public function getKey();

    /**
     * Sets label
     *
     * @param string
     */
    public function setLabel($label);

    /**
     * Returns label
     *
     * @param string
     */
    public function getLabel();

    /**
     * Sets text alignment
     *
     * @param string
     */
    public function setTextAlignment($textAlignment);

    /**
     * Returns text alignment
     *
     * @param string
     */
    public function getTextAlignment();

    /**
     * Sets value
     *
     * @param string
     */
    public function setValue($value);

    /**
     * Returns value
     *
     * @param string|int|float
     */
    public function getValue();

    /**
     * Sets Attributed Value
     *
     * @param string $attributedValue
     */
    public function setAttributedValue($attributedValue);

    /**
     * Return Attributed Value
     *
     * @return string
     */
    public function getAttributedValue();

    /**
     * Sets Data Detector Type
     *
     * @param array $dataDetectorTypes
     */
    public function setDataDetectorTypes(array $dataDetectorTypes);

    /**
     * Return Data Detector Type
     *
     * @return array
     */
    public function getDataDetectorTypes();
}
