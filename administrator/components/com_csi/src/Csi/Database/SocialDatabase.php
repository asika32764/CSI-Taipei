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
facebook(“教授中文姓名”OR”教授英文姓名”) (“機構名稱簡寫”OR”機構全名”) site:facebook.com                                                              twitter： (“教授中文姓名”OR”教授英文姓名”) (“機構名稱簡寫”OR”機構全名”) site:twitter.com
google plus：(“教授中文姓名” OR “教授英文姓名”) (""機構名稱簡寫""OR""機構全名"")site:plus.google.com
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

		$returnValue['entry'] = rand(1, 0);
		$returnValue['cited'] = rand(0, 15);
		$returnValue['mentioned'] = rand(0, 15);

		return new Data($returnValue);
	}
}
 