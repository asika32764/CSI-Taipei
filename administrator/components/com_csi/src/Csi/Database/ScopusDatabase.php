<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Csi\Database;

use Csi\Helper\KeywordHelper;
use Csi\Registry\RegistryHelper;
use Windwalker\Data\Data;

/**
 * The ScopusDatabase class.
 *
 * @since  {DEPLOY_VERSION}
 */
class ScopusDatabase extends AbstractDatabase
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
		$names = array();

		foreach ((array) $params->get('name.eng') as $n)
		{
			$names[] = implode(' ', (array) $n);
		}

		// Combine two
		$keyword = sprintf('AUTH(%s)', implode(' or ', $names));

		return $keyword;
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
		// In engine layer
	}
}
