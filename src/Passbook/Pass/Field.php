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
 * @author Eymen Gunay <eymen@egunay.com>
 */
class Field implements FieldInterface
{
    /**
     * @var string
     */
    const ALIGN_LEFT = 'PKTextAlignmentLeft';

    /**
     * @var string
     */
    const ALIGN_CENTER = 'PKTextAlignmentCenter';

    /**
     * @var string
     */
    const ALIGN_RIGHT = 'PKTextAlignmentRight';

    /**
     * @var string
     */
    const ALIGN_NATURAL = 'PKTextAlignmentNatural';

    /**
     * @var string
     */
    const PKDataDetectorTypePhoneNumber = 'PKDataDetectorTypePhoneNumber';

    /**
     * @var string
     */
    const PKDataDetectorTypeLink = 'PKDataDetectorTypeLink';

    /**
     * @var string
     */
    const PKDataDetectorTypeAddress = 'PKDataDetectorTypeAddress';

    /**
     * @var string
     */
    const PKDataDetectorTypeCalendarEvent = 'PKDataDetectorTypeCalendarEvent';

    /**
     * Format string for the alert text that is displayed when the pass is updated.
     * The format string may contain the escape %@, which is replaced with the
     * field’s new value. For example, “Gate changed to %@.”
     * @var string
     */
    protected $changeMessage;

    /**
     * The key must be unique within the scope of the entire pass.
     * For example, “departure-gate”.
     * @var array
     */
    protected $key;

    /**
     * Label text for the field.
     * @var string
     */
    protected $label;

    /**
     * Alignment for the field’s contents. Must be one of the following values:
     * PKTextAlignmentLeft, PKTextAlignmentCenter, PKTextAlignmentRight, PKTextAlignmentNatural
     * The default value is natural alignment,
     * which aligns the text appropriately based on its script direction.
     * This key is not allowed for primary fields.
     * @var string
     */
    protected $textAlignment;

    /**
     * Value of the field. For example, 42.
     * @var mixed ISO 8601 date as a string, or number
     */
    protected $value;

    /**
     * Array of strings
     * The default value is all data detectors. Provide an empty array to use no data detectors.
     * Data detectors are applied only to back fields.
     * @link https://developer.apple.com/library/ios/documentation/userexperience/Reference/PassKit_Bundle/Chapters/FieldDictionary.html#//apple_ref/doc/uid/TP40012026-CH4-SW1
     * @var array
     */
    protected $dataDetectorTypes;

    /**
     * Localizable string, ISO 8601 date as a string, or number
     * @var string
     */
    protected $attributedValue;

    public function __construct($key, $value)
    {
        // Required
        $this->setKey($key);
        $this->setValue($value);
    }

    public function toArray()
    {
        $array = array(
            'key' => $this->getKey(),
            'value' => $this->getValue()
        );

        if ($this->getChangeMessage()) {
            $array['changeMessage'] = $this->getChangeMessage();
        }

        if ($this->getLabel()) {
            $array['label'] = $this->getLabel();
        }

        if ($this->getTextAlignment()) {
            $array['textAlignment'] = $this->getTextAlignment();
        }

        if ($this->getDataDetectorTypes()) {
            $array['dataDetectorTypes'] = $this->getDataDetectorTypes();
        }

        if ($this->getAttributedValue()) {
            $array['attributedValue'] = $this->getAttributedValue();
        }

        return $array;
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

    /**
     * {@inheritdoc}
     */
    public function setAttributedValue($attributedValue)
    {
        $this->attributedValue = $attributedValue;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributedValue()
    {
        return $this->attributedValue;
    }

    /**
     * {@inheritdoc}
     */
    public function setDataDetectorTypes(array $dataDetectorTypes)
    {
        $this->dataDetectorTypes = $dataDetectorTypes;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataDetectorTypes()
    {
        return $this->dataDetectorTypes;
    }
}