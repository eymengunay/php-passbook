<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Type;

/**
 * Pass
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class Pass
{
	/**
	 * Pass name
	 * @var string
	 */
	protected $name;

	/**
	 * Pass type
	 * @var string
	 */
	protected $type;

	public function __construct($name)
	{
		// Required
		$this->name = $name;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getType()
	{
		return $this->type;
	}
}