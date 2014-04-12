<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Engine;

use Csi\Helper\KeywordHelper;
use Joomla\String\String;
use PHPHtmlParser\Dom;
use Windwalker\Data\Data;
use Windwalker\Helper\CurlHelper;

/**
 * Class GoogleEngine
 *
 * @since 1.0
 */
class GoogleEngine extends AbstractEngine
{
	/**
	 * Property pages.
	 *
	 * @var  int
	 */
	public $pages = 10 ;

	/**
	 * Property links.
	 *
	 * @var  int
	 */
	public $links = 100 ;

	/**
	 * Property host.
	 *
	 * @var  string
	 */
	protected $host = 'https://www.google.com.tw';

	/**
	 * Property path.
	 *
	 * @var  string
	 */
	public $path = '/search' ;

	/**
	 * Property query.
	 *
	 * @var  array
	 */
	public $query = array(
		'q'     => null ,
		'hl'    => 'zh-TW' ,
		'ie'    => 'UTF-8',
		'num'   => 100 ,
		'filter'=> 0 ,
		// 'safe'  => 'on',
		'start' => null
	) ;

	/**
	 * getPageList
	 *
	 * @return  \Windwalker\Data\Data[]
	 */
	public function getPageList()
	{
		$html = $this->getPage(1);

		$dom = new Dom;
		$dom->load($html);

		$td = $dom->find('table#nav td') ;

		// Count pagination buttons
		$num = count($td) ;

		// Remove previous and next buttons
		$num = $num - 2 ;

		// If no page buttons, means only 1 page, or we get buttons number as pages number.
		$num = ($num < 1) ? 1 : $num ;

		$pages = array();

		foreach (range(1, $num) as $row)
		{
			$page = new Data;

			$page->num = $row;
			$page->url = (string) $this->prepareUrl($row);

			$pages[] = $page;
		}

		return $pages;
	}

	/**
	 * getPage
	 *
	 * @param int $page
	 *
	 * @return  string|null
	 *
	 * @throws \InvalidArgumentException
	 */
	public function getPage($page = 1)
	{
		if ($page < 1)
		{
			throw new \InvalidArgumentException('Page should bigger than 0.');
		}

		if (!$this->state->get('keyword'))
		{
			return null;
		}

		$uri = $this->prepareUrl($page);

		// return RefCurlHelper::getPageHTML((string) $uri);
		$html = CurlHelper::get((string) $uri, 'get', null, array(CURLOPT_ENCODING => 'UTF-8'))->body;

		$html = String::transcode($html, 'big5', 'UTF-8');

		return $html;
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
		$html = $html ? : $this->state->get('parse.html');

		/** @var $page Dom */
		$page   = with(new Dom)->load($html);
		$result = array();

		// Get normal link
		$links = $page->find('div#ires ol li.g');

		foreach ($links as $k => $link)
		{
			/** @var $link Dom */
			$normal = $link->find('h3.r a');

			$item = array();

			// Get title and url
			$item['title'] = strip_tags($normal[0]->innerhtml);

			$url = new \JUri((string) $normal[0]->href);

			$item['url'] = urldecode($url->getVar('q'));

			// File type
			$fileType = $link->find('span.mime');

			$item['filetype'] = 'html';

			if (isset($fileType[0]))
			{
				$type = trim($fileType[0]->text);
				$type = str_replace('[', '', $type);
				$type = str_replace(']', '', $type);
				$type = strtolower($type);

				$item['filetype'] = $type;
			}

			// Storage
			/* We don't need storage now
			$storage = $link->find('span.gl a');
			$result[$k]['google-storage'] = null;

			if (isset($storage[0]->href))
			{
				$result[$k]['google-storage'] = $result[$k]['normal'];
				$result[$k]['google-storage']['url'] = $storage[0]->href;
			}
			*/

			$result[] = new Data($item);
		}

		return $result;
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

		// Prepare keyword
		$text = KeywordHelper::encode($this->state->get('keyword'));

		$uri->setQuery($this->query) ;
		$uri->setVar('q', $text);

		$uri->setVar('start' , ($page - 1) * $this->links);

		return $uri;
	}
}
 