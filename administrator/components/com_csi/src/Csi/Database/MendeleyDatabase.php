<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Database;

use Csi\Helper\KeywordHelper;
use Csi\Registry\RegistryHelper;
use Windwalker\Data\Data;

/**
 * Class MendeleyDatabase
 *
 * @since 1.0
 */
class MendeleyDatabase extends AbstractDatabase
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
		$names = KeywordHelper::arrangeEngNames($params->get('name.eng'));

		$names = KeywordHelper::buildNameConditions($names);

		return $names;
	}

	/**
	 * parseResult
	 *
	 * @param string $txt
	 *
	 * @return  \Windwalker\Data\Data
	 */
	public function parseResult($txt)
	{

	}
}
 