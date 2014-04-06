<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Database;

use Windwalker\Data\Data;

/**
 * Class AbstractDatabase
 *
 * @since 1.0
 */
abstract class AbstractDatabase extends \JModelBase
{
	/**
	 * getInstance
	 *
	 * @param string $name
	 *
	 * @return  AbstractDatabase
	 */
	public static function getInstance($name)
	{
		$class = sprintf('Csi\\Database\\%sDatabase', ucfirst($name));

		return new $class;
	}

	/**
	 * getKeyword
	 *
	 * @param Data $task
	 *
	 * @return  string
	 */
	abstract public function getKeyword(Data $task);

	/**
	 * parseResult
	 *
	 * @param string $txt
	 *
	 * @return  \Windwalker\Data\Data
	 */
	abstract public function parseResult($txt);
}
 