<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook;

/**
 * Pass
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class Pass
{
	/**
	 * Serial number that uniquely identifies the pass. 
	 * No two passes with the same pass type identifier 
	 * may have the same serial number.
	 * @var string
	 */
	protected $serialNumber;

	/**
	 * Pass name
	 * @var string
	 */
	protected $name;

	/**
	 * Brief description of the pass,
	 * used by the iOS accessibility technologies.
	 * @var string
	 */
	protected $description;

	/**
	 * Date and time when the pass becomes relevant.
	 * 
	 * For example, the start time of a movie.
	 * The value must be a complete date with hours 
	 * and minutes, and may optionally include seconds.
	 * @var string
	 */
	protected $relevantDate;

	/**
	 * Pass type
	 * @var string
	 */
	protected $type;

	/**
	 * Version of the file format. 
	 * The value must be 1.
	 * @var int
	 */
	protected $formatVersion = 1;

	public function __construct($serialNumber, $name, $description)
	{
		// Required
		$this->serialNumber = $serialNumber;
		$this->name 		= $name;
		$this->description 	= $description;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setSerialNumber($serialNumber)
	{
		$this->serialNumber = $serialNumber;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSerialNumber()
	{
		return $this->serialNumber;
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
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return $this->description;
	}
}