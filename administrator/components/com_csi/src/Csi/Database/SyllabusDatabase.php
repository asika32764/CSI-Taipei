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
use Csi\Registry\RegistryHelper;
use Windwalker\Data\Data;

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
		$params = RegistryHelper::loadString($task->params);

		// Build name keyword
		$names = KeywordHelper::buildNamesKeyword($params->get('name.chinese'), $params->get('name.eng'));

		// Get syllabus keyword
		$suffix = Config::get('database.syllabus.keyword');

		$suffix = implode(' OR ', $suffix);

		// Combine two
		$keyword = sprintf('(%s) AND (%s)', $names, $suffix);

		return $keyword;
	}
}
 