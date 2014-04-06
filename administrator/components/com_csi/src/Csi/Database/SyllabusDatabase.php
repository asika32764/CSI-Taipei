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

	/**
	 * parseResult
	 *
	 * @param string $txt
	 *
	 * @return  \Windwalker\Data\Data
	 */
	public function parseResult($txt)
	{
		// Prepare params
		$professors_titles = $this->state->get('professors.titles', array());
		$professors_names  = $this->state->get('professors.names', array());
		$units             = $this->state->get('ranges.units', 5);
		$course_terms      = $this->state->get('terms.course', array());
		$reference_terms   = $this->state->get('terms.reference', array());

		$patterns = "/<script(.*?)script>/s";
		$replace  = "";
		$txt      = preg_replace($patterns, $replace, $txt);

		$patterns = "/<SCRIPT(.*?)SCRIPT>/s";
		$replace  = "";
		$txt      = preg_replace($patterns, $replace, $txt);

		$patterns = "/<style(.*?)style>/s";
		$replace  = "";
		$txt      = preg_replace($patterns, $replace, $txt);

		// Convert to text
		$txt = strip_tags($txt);

		// Detect encoding
		$encoding = mb_detect_encoding($txt);

		// If is BIG5, convert encoding to utf-8
		if ($encoding != 'UTF-8')
		{
			$txt = iconv("CP950", "UTF-8//IGNORE", $txt);
		}

		$txtmp  = $txt;
		$txtmp2 = str_replace(array("\r\n", "\r", "\n"), "\t", trim($txt));
		$txtmp2 = str_replace(array("　"), '', $txtmp2);
		$txtmp2 = mb_ereg_replace("[\t \.\(\)\~\\\"，；、：‧（）【】〔〕「」『』〈〉《》＜＞★☆…？！〃◎" . "\xEF\xBC\x8F" . "]", '', $txtmp2);

		// Detect self_cited OR Cited.
		$self_cited = false;

		$titleRegString = "";

		for ($i = 0; $i < count($professors_titles); $i++)
		{
			$titleRegString .= preg_quote($professors_titles[$i]);

			if ($i != (count($professors_titles) - 1))
			{
				$titleRegString .= "|";
			}
		}

		$nameRegString = "";

		for ($i = 0; $i < count($professors_names); $i++)
		{
			$nameRegString .= preg_quote($professors_names[$i]);

			if ($i != (count($professors_names) - 1))
			{
				$nameRegString .= "|";
			}
		}

		//echo "/(".$titleRegString.")(.{0,".$units."})(".$nameRegString."))/u";
		if (preg_match("/(" . $titleRegString . ")(.{0," . $units . "})(" . $nameRegString . ")/u", $txtmp2, $match))
		{
			$self_cited = true;
		}

		// detect is before course terms?
		$p = false;

		foreach ($course_terms as $course_term)
		{
			$p = strpos($txt, $course_term);

			if ($p !== false)
			{
				break;
			}
		}

		if ($p > 0)
		{
			$txtmp = substr($txtmp, $p);
		}

		// detect is before reference terms?
		$p = false;

		foreach ($reference_terms as $reference_term)
		{
			$p = strpos($txt, $reference_term);

			if ($p !== false)
			{
				break;
			}
		}

		if ($p > 0)
		{
			$txtmp = substr($txtmp, $p);
		}

		// detect professors name
		$txtmps = explode("\n", $txtmp);
		$result = array();

		foreach ($txtmps as $row)
		{
			$p = false;

			foreach ($professors_names as $professors_name)
			{
				$p = strpos($row, $professors_name);

				if ($p !== false)
				{
					$result[] = $row;

					break;
				}
			}
		}

		if ($self_cited)
		{
			$returnValue['self_cited'] = count($result);
			$returnValue['cited'] = 0;
			$returnValue['self_syllabus'] = true;
			$returnValue['is_syllabus'] = true;
		}
		else
		{
			$returnValue['self_cited'] = 0;
			$returnValue['cited'] = count($result);
			$returnValue['self_syllabus'] = false;
			$returnValue['is_syllabus'] = true;
		}

		return new Data($returnValue);
	}
}
 