<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Engine;

/**
 * Class AbstractEngine
 *
 * @since 1.0
 */
class AbstractEngine
{
	/**
	 * Property keyword.
	 *
	 * @var  string
	 */
	protected $keyword = null;

	/**
	 * getInstance
	 *
	 * @param string $name
	 *
	 * @return  AbstractEngine
	 */
	public static function getInstance($name)
	{
		$class = sprintf('Csi\\Engine\\%sEngine', ucfirst($name));

		return new $class;
	}

	public function getPageList()
	{

	}

	/**
	 * getKeyword
	 *
	 * @return  string
	 */
	public function getKeyword()
	{
		return $this->keyword;
	}

	/**
	 * setKeyword
	 *
	 * @param   string $keyword
	 *
	 * @return  AbstractEngine  Return self to support chaining.
	 */
	public function setKeyword($keyword)
	{
		$this->keyword = $keyword;

		return $this;
	}
}
 