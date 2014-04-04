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
}
 