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
 * Class NumberField
 * @package Passbook\Pass
 * @author Florian Morello <florian@morello.fr>
 */
class NumberField extends Field {

	/**
	 * @var string
	 */
	const PKNumberStyleDecimal = 'PKNumberStyleDecimal';

	/**
	 * @var string
	 */
	const PKNumberStylePercent = 'PKNumberStylePercent';

	/**
	 * @var string
	 */
	const PKNumberStyleScientific = 'PKNumberStyleScientific';

	/**
	 * ISO 4217
	 * @var string
	 */
	protected $currencyCode = null;

	/**
	 * @var string
	 */
	protected $numberStyle = null;

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
	 * @param mixed $currencyCode
	 */
	public function setCurrencyCode($currencyCode)
	{
		$this->currencyCode = $currencyCode;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCurrencyCode()
	{
		return $this->currencyCode;
	}

	/**
	 * @param string $numberStyle
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
}