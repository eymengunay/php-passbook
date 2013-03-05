<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\File;

use Passbook\Exception\FileException;
use Passbook\Exception\FileNotFoundException;

/**
 * Image
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class Image extends File implements ImageInterface
{
	/**
	 * [$type description]
	 * @var [type]
	 */
	protected $type;

	/**
	 * {@inheritdoc}
	 */
	public function setType($type)
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getType()
	{
		
	}

	/**
	 * {@inheritdoc}
	 */
	public function setIsRetina()
	{
		
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIsRetina($isRetina)
	{
		
	}
}