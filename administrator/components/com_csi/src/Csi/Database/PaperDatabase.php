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
use PHPHtmlParser\Dom;
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
(教授 OR 博士) AND intitle:"周刊OR週刊OR月刊OR雜誌OR簡訊OR通訊OR評論OR新聞OR報" AND -inurl:youtube AND (inurl:com OR inurl:gov)
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
		$isAuthor = 0;
		$names = $this->state->get('professors.names');

		// Check Author
		preg_match_all('/<[a-zA-Z1-9]+.*class=\"[\sa-zA-Z1-9-_]*author[\sa-zA-Z1-9-_]*\".*>.*<\/[a-zA-Z1-9]+>/i', $txt, $matches);

		foreach ($matches as $match)
		{
			if (isset($match[0]))
			{
				$author = strip_tags($match[0]);

				foreach ($names as $name)
				{
					if (strpos(strtolower($author), strtolower($name)) !== false)
					{
						$isAuthor = 1;
						break;
					}
				}
			}

			if ($isAuthor)
			{
				break;
			}
		}

		$cited = 0;
		$mentioned = 0;

		if (!$isAuthor)
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

		$returnValue['cited'] = $cited;
		$returnValue['author'] = $isAuthor;
		$returnValue['mentioned'] = $mentioned;

		return new Data($returnValue);
	}
}
 