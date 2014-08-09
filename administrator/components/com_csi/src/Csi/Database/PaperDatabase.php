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
class PaperDatabase extends AbstractDatabase
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
(intext:教授 OR intext:博士)
 AND intitle:"周刊OR週刊OR月刊OR雜誌OR簡訊OR通訊OR評論OR新聞OR報"
 AND -inurl:youtube
 AND -inurl:roodo
 AND -inurl:blog
 AND -inurl:pixnet
 AND -inurl:books
 AND -inurl:blogspot
 AND -inurl:myblog
 AND -inurl:wordpress
 AND -inurl:angle
 AND -inurl:sharing
 AND -inurl:waterlike
 AND -inurl:bid
 AND -inurl:taaze
 AND -inurl:pchome
 AND -inurl:ptt
 AND -inurl:forum
 AND (inurl:"com" OR "gov")
KWD;
		// Combine two
		$keyword = sprintf('(intext: %s) %s', $names, $keyword);

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
		$isAuthor = rand(0, 1);

		// @TODO: Implement this parser.

		if ($isAuthor)
		{
			$returnValue['cited'] = 0;
			$returnValue['author'] = 1;
			$returnValue['mentioned'] = 0;
		}
		else
		{
			$returnValue['cited'] = rand(1, 5);
			$returnValue['author'] = 0;
			$returnValue['mentioned'] = 1;
		}

		return new Data($returnValue);
	}
}
 