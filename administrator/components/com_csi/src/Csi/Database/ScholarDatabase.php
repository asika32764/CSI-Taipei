<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Database;

use Csi\Config\Config;
use Csi\Encoding\Encoding;
use Csi\Helper\KeywordHelper;
use Csi\Registry\RegistryHelper;
use Joomla\Filter\InputFilter;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\HtmlNode;
use Windwalker\Data\Data;

/**
 * Class SyllabusDatabase
 *
 * @since 1.0
 */
class ScholarDatabase extends AbstractDatabase
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
		$keyword = KeywordHelper::buildNamesKeyword($params->get('name.chinese'), $params->get('name.eng'));

		$keyword = 'author:' . str_replace('OR ', 'OR author:', $keyword);

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
		$returnValue = new Data(
			array(
				'cited' => 0,
				'author' => 0
			)
		);

		// Detect encoding
		$encoding = mb_detect_encoding($txt);

		// If is BIG5, convert encoding to utf-8
		if ($encoding != 'UTF-8')
		{
			$txt = iconv("CP950", "UTF-8//IGNORE", $txt);
		}

		$filter = new InputFilter;

		$html = new Dom;

		$html->load($txt);

		$cites = $html->find('div.gs_fl a');

		foreach ($cites as $cite)
		{
			/** @var HtmlNode $cite */
			$text = $cite->text;

			// $text = Encoding::toUtf8($text);

			if (strpos($text, '引用') !== false)
			{
				$returnValue['cited'] += $filter->clean($text, 'int');
			}
		}

		$lists = $html->find('#gs_ccl div.gs_r');

		$returnValue['author'] = count($lists);

		return $returnValue;
	}
}
 