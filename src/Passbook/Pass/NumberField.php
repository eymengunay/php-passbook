<?php
/**
 * User: arsonik
 * Date: 18/02/14
 * Time: 17:20
 */

namespace Passbook\Pass;


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
}