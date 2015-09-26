<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Csi\Engine;

use Joomla\String\String;
use PHPHtmlParser\Dom;
use Windwalker\Data\Data;
use Windwalker\Helper\ArrayHelper;
use Windwalker\Helper\CurlHelper;

/**
 * The ArtitiEngine class.
 *
 * @since  {DEPLOY_VERSION}
 */
class AiritiEngine extends AbstractEngine
{
	/**
	 * Property host.
	 *
	 * @var  string
	 */
	protected $host = 'http://www.airitilibrary.com';

	/**
	 * Property path.
	 *
	 * @var  string
	 */
	public $path = '/Search/AdvanceResearch';

	/**
	 * Property query.
	 *
	 * @var  array
	 */
	public $query = array(
		'SearchFieldList_obj' => null,
		'TraditionalChinese' => 'false',
		'SimplifiedChinese' => 'false',
		'English' => 'false',
		'OtherLanguage' => 'false',
		'EJournal' => 'false',
		'Proceedings' => 'false',
		'Dissertations' => 'true',
		'EBook' => 'false',
		'Taiwan' => 'false',
		'ChinaHongKongMacao' => 'false',
		'American' => 'false',
		'OtherArea' => 'false',
		'Text' => '',
		'Years' => array(),
		'Sort' => '',
		'PageSize' => 10,
		'QueryExpression' => '',
	);

	/**
	 * getPageList
	 *
	 * @return  \Windwalker\Data\Data[]
	 */
	public function getPageList()
	{
		// No result

		return new Data;
	}

	/**
	 * prepareUrl
	 *
	 * @param int $page
	 *
	 * @return  \JUri
	 */
	public function prepareUrl($page = 1)
	{
		$uri = parent::prepareUrl($page);

		$uri->setQuery($this->query);

		$keyword = $this->state->get('keyword', array());

		$name = ArrayHelper::getValue($keyword, 'chinese_name');

		$query = array(array(
			'SearchString' => $name,
			'SearchType' => '指導教授'
		));

		$query = json_encode($query);
		$query = String::unicode_to_utf8($query);

		$uri->setVar('SearchFieldList_obj', $query);

		return $uri;
	}

	/**
	 * parsePage
	 *
	 * @param string $html
	 *
	 * @return  \Windwalker\Data\Data[]
	 */
	public function parsePage($html = null)
	{
		/** @var Dom $dom */
		$type   = $this->state->get('type', 'cited');
		$dom    = with(new Dom)->load($html);
		$result = new Data;

		$num = $dom->find('div#SummaryListPage .onlypageall .txt1');

		if (isset($num[0]))
		{
			$text = $num[0]->text;

			preg_match('/([\d]+)/', $text, $matches);

			if (isset($matches[1]))
			{
				$result->advisor = $matches[1];
			}
		}

		return $result;
	}
}
