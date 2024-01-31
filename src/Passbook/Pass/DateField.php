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
 * Class DateField
 * @package Passbook\Pass
 * @link https://developer.apple.com/library/ios/documentation/userexperience/Reference/PassKit_Bundle/Chapters/FieldDictionary.html#//apple_ref/doc/uid/TP40012026-CH4-SW1
 * @author Florian Morello <florian@morello.fr>
 * @phpcs:disable Generic.NamingConventions.UpperCaseConstantName
 */
class DateField extends Field
{
    /**
     * @deprecated please use ::DATE_STYLE_NONE instead.
     */
    public const PKDateStyleNone = 'PKDateStyleNone';

    /**
     * @deprecated please use ::DATE_STYLE_SHORT instead.
     */
    public const PKDateStyleShort = 'PKDateStyleShort';

    /**
     * @deprecated please use ::DATE_STYLE_MEDIUM instead.
     */
    public const PKDateStyleMedium = 'PKDateStyleMedium';

    /**
     * @deprecated please use ::DATE_STYLE_LONG instead.
     */
    public const PKDateStyleLong = 'PKDateStyleLong';

    /**
     * @deprecated please use ::DATE_STYLE_FULL instead.
     */
    public const PKDateStyleFull = 'PKDateStyleFull';

    /**
     * @var string
     */
    public const DATE_STYLE_NONE = 'PKDateStyleNone';

    /**
     * @var string
     */
    public const DATE_STYLE_SHORT = 'PKDateStyleShort';
    /**
     * @var string
     */
    public const DATE_STYLE_MEDIUM = 'PKDateStyleMedium';

    /**
     * @var string
     */
    public const DATE_STYLE_LONG = 'PKDateStyleLong';

    /**
     * @var string
     */
    public const DATE_STYLE_FULL = 'PKDateStyleFull';

    /**
     * @var string
     */
    protected $dateStyle;

    /**
     * @var bool
     */
    protected $ignoresTimeZone;

    /**
     * @var bool
     */
    protected $isRelative;

    /**
     * @var string
     */
    protected $timeStyle;

    /**
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();

        if (strlen($this->getDateStyle())) {
            $array['dateStyle'] = $this->getDateStyle();
        }
        if (is_bool($this->getIgnoresTimeZone())) {
            $array['ignoresTimeZone'] = $this->getIgnoresTimeZone();
        }
        if (is_bool($this->getIsRelative())) {
            $array['isRelative'] = $this->getIsRelative();
        }
        if (strlen($this->getTimeStyle())) {
            $array['timeStyle'] = $this->getTimeStyle();
        }

        return $array;
    }

    /**
     * Must be one of PKDateStyle const
     * @param string $dateStyle
     */
    public function setDateStyle($dateStyle)
    {
        $this->dateStyle = $dateStyle;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateStyle()
    {
        return (string) $this->dateStyle;
    }

    /**
     * @param boolean $ignoresTimeZone
     */
    public function setIgnoresTimeZone($ignoresTimeZone)
    {
        $this->ignoresTimeZone = $ignoresTimeZone;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getIgnoresTimeZone()
    {
        return $this->ignoresTimeZone;
    }

    /**
     * @param boolean $isRelative
     */
    public function setIsRelative($isRelative)
    {
        $this->isRelative = $isRelative;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsRelative()
    {
        return $this->isRelative;
    }

    /**
     * Must be one of PKDateStyle const
     * @param string $timeStyle
     */
    public function setTimeStyle($timeStyle)
    {
        $this->timeStyle = $timeStyle;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimeStyle()
    {
        return (string) $this->timeStyle;
    }

    /**
     * Must be a ISO 8601 date string or a \DateTime object
     * @param string|\DateTime $value
     * @return $this
     */
    public function setValue($value)
    {
        if ($value instanceof \DateTime) {
            $value = $value->format('c');
        }

        return parent::setValue($value);
    }
}
