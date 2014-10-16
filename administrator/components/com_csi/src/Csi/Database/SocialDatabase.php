<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Database;

use Csi\Config\Config;
use Csi\Helper\KeywordHelper;
use Csi\Registry\RegistryHelper;
use Windwalker\Data\Data;
use Windwalker\String\String;

/**
 * The WikiDatabase class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class SocialDatabase extends AbstractDatabase
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

		$instNames = KeywordHelper::buildNameConditions($params->get('name.school'));

		$instNames = $instNames ? ' (' . $instNames . ')' : null;

		$keyword = array();

		foreach (Config::get('database.social.sites', array()) as $site)
		{
			// Combine two
			$keyword[$site] = sprintf('(%s)%s site:%s', $names, $instNames, $site);
		}

		return json_encode(str_replace(array("\n", "\r"), '', $keyword));
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
		// @TODO: Implement this parser.

		$returnValue['author'] = rand(0, 1);
		$returnValue['cited'] = rand(0, 15);
		$returnValue['mentioned'] = rand(0, 15);

		return new Data($returnValue);
	}
}
 