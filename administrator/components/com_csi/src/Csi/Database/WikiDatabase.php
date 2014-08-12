<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Database;

use Csi\Helper\KeywordHelper;
use Csi\Registry\RegistryHelper;
use Windwalker\Data\Data;

/**
 * The WikiDatabase class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class WikiDatabase extends AbstractDatabase
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

		// Search keyword
		$keyword = <<<KWD
site:zh.wikipedia.org/ inurl:"zh-tw" OR "wiki" AND -inurl:template AND -inurl:category AND -inurl:talk
KWD;
		// Combine two
		$keyword = sprintf('(%s) %s', $names, $keyword);

		return str_replace(array("\n", "\r"), '', $keyword);
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

		$returnValue['entry'] = rand(0, 1);
		$returnValue['cited'] = rand(0, 15);
		$returnValue['mentioned'] = rand(0, 15);

		return new Data($returnValue);
	}
}
 