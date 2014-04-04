<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Database;

use Csi\Config\Config;
use Csi\Helper\KeywordHelper;
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

		$names = KeywordHelper::arrangeNames($names->chinese, $names->eng);

		$names .= ' ' . Config::get('database.syllabus.keyword');

		return $names;
	}
}
 