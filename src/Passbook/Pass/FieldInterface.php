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
     * @param string $changeMessage
     */
    public function setChangeMessage($changeMessage);

    /**
     * Returns change message
     *
     * @return string
     */
    public function getChangeMessage();

    /**
     * Sets key
     *
     * @param string $key
     */
    public function setKey($key);

    /**
     * Returns key
     *
     * @return string
     */
    public function getKey();

    /**
     * Sets label
     *
     * @param string $label
     */
    public function setLabel($label);

    /**
     * Returns label
     *
     * @return string
     */
    public function getLabel();

    /**
     * Sets text alignment
     *
     * @param string $textAlignment
     */
    public function setTextAlignment($textAlignment);

    /**
     * Returns text alignment
     *
     * @return string
     */
    public function getTextAlignment();

    /**
     * Sets value
     *
     * @param string $value
     */
    public function setValue($value);

    /**
     * Returns value
     *
     * @return string|int|float
     */
    public function getValue();

    /**
     * Sets Attributed Value
     *
     * @param string $attributedValue $attributedValue
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
