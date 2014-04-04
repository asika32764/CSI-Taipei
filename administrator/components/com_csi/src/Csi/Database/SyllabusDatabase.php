<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Database;

use Csi\Config\Config;
use Windwalker\Data\Data;
use Windwalker\String\String;

/**
 * Class SyllabusDatabase
 *
 * @since 1.0
 */
class SyllabusDatabase extends AbstractDatabase
{
	/**
	 * getKeyword
	 *
	 * @param Data $task
	 *
	 * @return  string
	 */
	public function getKeyword(Data $task)
	{
		$names = $task->names;

		$names = array_map(
			function($value)
			{
				return String::quote($value, '"');
			},
			$names
		);

		$names = implode(' ', $names);

		$names .= ' ' . Config::get('database.syllabus.keyword');

		return $names;
	}
}
 