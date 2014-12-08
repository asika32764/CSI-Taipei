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
class TciDatabase extends AbstractDatabase
{
	const TYPE_AUTHOR = 'author';
	const TYPE_CITED = 'cited';

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
		$keyword = KeywordHelper::arrangeNames($params->get('name.chinese'), $params->get('name.eng'));

		return json_encode($keyword);
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
		return true;
	}

	/**
	 * parseAuthor
	 *
	 * @param string $txt
	 *
	 * @return  int
	 */
	public function parseAuthor($txt)
	{
		$r = preg_match('/查詢結果共<span class="etd_e">&nbsp;([\d]*)&nbsp;<\/span>筆資料/', $txt, $matched);

		return $r ? $matched[1] : 0;
	}
}
 