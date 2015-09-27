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
use PHPHtmlParser\Dom;
use Windwalker\Data\Data;
use Windwalker\Helper\CurlHelper;
use Windwalker\String\String;

/**
 * The WikiDatabase class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class SocialDatabase extends AbstractDatabase
{
	const FACEBOOK    = 'facebook';
	const GOOGLE_PLUS = 'gplus';
	const TWITTER     = 'twitter';

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
		$dom     = new Dom;
		$name    = null;
		$content = null;

		$platform = $this->state->get('platform');
		$platform = static::TWITTER;

		switch ($platform)
		{
			case static::FACEBOOK:

				preg_match('/<!-- (<div class="_5pcb"><h2 class="accessible_elem" id="newsFeedHeading".*)-->/', $txt, $matches);

				if (isset($matches[1]))
				{
					$dom->load($matches[1]);
					$nameHtml = $dom->find('.fcg');
					$name = trim(strip_tags($nameHtml->outerHtml));

					$contentHtml = $dom->find('.userContent');
					$content = strip_tags($contentHtml->outerHtml);
				}

				break;

			case static::GOOGLE_PLUS:

				$dom->load($txt);
				$nameHtml = $dom->find('a.Hf');

				$name = trim(strip_tags($nameHtml->outerHtml));

				$contentHtml = $dom->find('.Ct');
				$content = strip_tags($contentHtml->outerHtml);

				break;

			case static::TWITTER:

				$dom->load($txt);
				$nameHtml = $dom->find('.js-action-profile-name');

				$name = trim(strip_tags($nameHtml->text), ' <>');

				$contentHtml = $dom->find('.tweet-text');
				$content = strip_tags($contentHtml->outerHtml);

				break;
		}

		// Analysis
		$professors_names = $this->state->get('professors.names', array());
		$reference_terms  = $this->state->get('terms.reference', array());

		// Check is author
		$author = 0;
		foreach ($professors_names as $professorName)
		{
			if (strtolower($name) == strtolower($professorName))
			{
				$author = 1;
			}
		}

		$content = strtolower($content);

		// Separate reference and content
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
		$mentioned = 0;

		foreach ($professors_names as $professorName)
		{
			$mentioned += substr_count($content, strtolower($professorName));
		}

		// Find Cited
		$cited = 0;
		$refs = explode("\n", $reference);

		foreach ($refs as $ref)
		{
			$ref = trim($ref);

			foreach ($professors_names as $professorName)
			{
				if (strpos($ref, strtolower($professorName)) !== false)
				{
					$cited++;
					break;
				}
			}
		}

		$returnValue['author']    = $author;
		$returnValue['cited']     = $cited;
		$returnValue['mentioned'] = $mentioned;

		return new Data($returnValue);
	}
}
 