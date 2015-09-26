<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Csi\Engine;

use PHPHtmlParser\Dom;
use Windwalker\Data\Data;
use Windwalker\Helper\ArrayHelper;

/**
 * The EthesysEngine class.
 *
 * @since  {DEPLOY_VERSION}
 */
class EthesysEngine extends AbstractEngine
{
	const CITED   = 'cited';
	const ADVISOR = 'advisor';

	/**
	 * Property host.
	 *
	 * @var  string
	 */
	protected $host = 'http://fedetd.mis.nsysu.edu.tw';

	/**
	 * Property path.
	 *
	 * @var  string
	 */
	public $path = '/FED-db/cgi-bin/FED-search/browse';

	/**
	 * Property query.
	 *
	 * @var  array
	 */
	public $query = array(

	);

	/**
	 * getPageList
	 *
	 * @return  \Windwalker\Data\Data[]
	 */
	public function getPageList()
	{

	}

	public function prepareUrl($page = 1)
	{
		$uri = parent::prepareUrl($page);

		$type = $this->state->get('type', 'cited');

		$keyword = $this->state->get('keyword');

		// Cited
		if ($type == static::CITED)
		{
			foreach ((array) ArrayHelper::getValue($keyword, 'all_names') as $i => $name)
			{
				$uri->setVar('field' . ($i + 1), 'reference');
				$uri->setVar('query' . ($i + 1), $name);
				$uri->setVar('boolean' . ($i + 2), 'OR');
			}
		}
		else
		{
			$uri->setVar('advisor_title', 'advisor');
			$uri->setVar('advisor_name', ArrayHelper::getValue($keyword, 'chinese_name'));
		}

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

		// Cited
		if ($type == static::CITED)
		{
			$text = $dom->find('#container .contenter .info_block2 p font');

			if (isset($text[1]))
			{
				$result['cited'] = $text[1]->text;
			}
		}
		else
		{
			$text = $dom->find('#container .contenter .info_block2 p font');

			if (isset($text[1]))
			{
				$result['advisor'] = $text[1]->text;
			}
		}

		return $result;
	}
}
