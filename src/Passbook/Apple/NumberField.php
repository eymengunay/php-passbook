<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Apple;

use InvalidArgumentException;

/**
 * Class NumberField
 *
 * @author Florian Morello <florian@morello.fr>
 */
class NumberField extends Field
{
    /**
     * @var string
     */
    public const NUMBER_STYLE_DECIMAL = 'PKNumberStyleDecimal';

    /**
     * @var string
     */
    public const NUMBER_STYLE_PERCENT = 'PKNumberStylePercent';

    /**
     * @var string
     */
    public const NUMBER_STYLE_SCIENTIFIC = 'PKNumberStyleScientific';

    /**
     * ISO 4217
     *
     * @var string
     */
    protected $currencyCode = null;

    /**
     * @var string
     */
    protected $numberStyle = null;

    /**
     * NumberField constructor.
     * @param $key
     * @param $value
     * @throws InvalidArgumentException
     */
    public function __construct($key, $value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException("Value has to be numeric. '$value' given!");
        }

        parent::__construct($key, $value);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        if ($this->getCurrencyCode() !== null) {
            $array['currencyCode'] = $this->getCurrencyCode();
        }
        if ($this->getNumberStyle() !== null) {
            $array['numberStyle'] = $this->getNumberStyle();
        }

        return $array;
    }

    /**
     * @param string $currencyCode an ISO 4217 currency code
     *
     * @return $this
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param string $numberStyle
     *
     * @return $this
     */
    public function setNumberStyle($numberStyle)
    {
        $this->numberStyle = $numberStyle;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumberStyle()
    {
        return $this->numberStyle;
    }

    /**
     * {@inheritdoc}
     *
     * @return int|float
     */
    public function getValue()
    {
        // Ensure value is int or float; adding 0 will convert type from string
        return 0 + parent::getValue();
    }
}
