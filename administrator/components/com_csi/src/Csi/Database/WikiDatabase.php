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
use PHPHtmlParser\Dom;
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
		$names = $this->state->get('professors.names', array());

		$dom = new Dom;
		$dom->load($txt);
		$entry = 0;

		$title = $dom->find('#firstHeading');

		foreach ($names as $name)
		{
			if (strtolower($name) == strtolower($title->text))
			{
				$entry++;

				break;
			}
		}

		$cited = 0;
		$mentioned = 0;

		if (!$entry)
		{
			$reference_terms  = $this->state->get('terms.reference', array());
			$content = strtolower(strip_tags($txt));

			$reference = null;

			foreach ($reference_terms as $reference_term)
			{
				$reference_term = strtolower($reference_term);

				if (strpos($content, $reference_term) !== false)
				{
					$tmp = explode($reference_term, $content);

					if (isset($content[1]))
					{
						list($content, $reference) = $tmp;
					}

					break;
				}
			}

			// Find Mentioned
			foreach ($names as $professorName)
			{
				$mentioned += substr_count($content, strtolower($professorName));
			}

			// Find Cited
			$refs = explode("\n", $reference);

			foreach ($refs as $ref)
			{
				$ref = trim($ref);

				foreach ($names as $professorName)
				{
					if (strpos($ref, strtolower($professorName)) !== false)
					{
						$cited++;
						break;
					}
				}
			}
		}

		$returnValue['entry'] = $entry;
		$returnValue['cited'] = $cited;
		$returnValue['mentioned'] = $mentioned;

		return new Data($returnValue);
	}
}
 