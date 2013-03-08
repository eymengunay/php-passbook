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

/**
 * Field
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class Field implements FieldInterface
{
    /**
     * Format string for the alert text that is displayed when the pass is updated.
     * The format string may contain the escape %@, which is replaced with the
     * field’s new value. For example, “Gate changed to %@.”
     * 
     * @var string
     */
    public $changeMessage;

    /**
     * The key must be unique within the scope of the entire pass. 
     * For example, “departure-gate”.
     * 
     * @var array
     */
    public $key;

    /**
     * Label text for the field.
     * 
     * @var string
     */
    public $label;

    /**
     * Alignment for the field’s contents. Must be one of the following values:
     * PKTextAlignmentLeft, PKTextAlignmentCenter, PKTextAlignmentRight, PKTextAlignmentNatural
     * 
     * The default value is natural alignment, 
     * which aligns the text appropriately based on its script direction.
     *
     * This key is not allowed for primary fields.
     * 
     * @var string
     */
    public $textAlignment;

    /**
     * Value of the field. For example, 42.
     * @var mixed ISO 8601 date as a string, or number
     */
    public $value;

    public function __construct($key, $value)
    {
        // Required
        $this->key   = $key;
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function setChangeMessage($changeMessage)
    {
        $this->changeMessage = $changeMessage;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getChangeMessage()
    {
        return $this->changeMessage;
    }

    /**
     * {@inheritdoc}
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * {@inheritdoc}
     */
    public function setTextAlignment($textAlignment)
    {
        $this->textAlignment = $textAlignment;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTextAlignment()
    {
        return $this->textAlignment;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }
}