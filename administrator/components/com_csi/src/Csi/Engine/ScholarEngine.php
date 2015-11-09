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
class ScholarEngine extends AbstractEngine
{
	/**
	 * Property pages.
	 *
	 * @var  int
	 */
	public $pages = 50 ;

	/**
	 * Property links.
	 *
	 * @var  int
	 */
	public $links = 20 ;

	/**
	 * Property host.
	 *
	 * @var  string
	 */
	protected $host = 'http://scholar.google.com.tw';

	/**
	 * Property path.
	 *
	 * @var  string
	 */
	public $path = '/scholar' ;

	/**
	 * Property query.
	 *
	 * @var  array
	 */
	public $query = array(
		'q'     => null ,
		'hl'    => 'zh-TW' ,
		'ie'    => 'UTF-8',
		'num'   => 20 ,
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

		$rows = $dom->find('#gs_ab_md') ;

		$rows = $rows[0]->text;

		preg_match('/\d+/', $rows, $match);

		$pages = array();

		if (!isset($match[0]))
		{
			return $pages;
		}

		$num = ceil($match[0] / $this->links);

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
		$links = $page->find('div#gs_ccl .gs_r');

		foreach ($links as $k => $link)
		{
			/** @var $link Dom */
			$normal = $link->find('h3.gs_rt a');

			if (!count($normal))
			{
				continue;
			}

			$item = array();

			// Get title and url
			$item['title'] = strip_tags($normal[0]->innerhtml);

			$url = new \JUri((string) $normal[0]->href);

			$item['url'] = urldecode($url->getVar('q'));

			// File type
			$fileType = $link->find('span.gs_ctg2');

			$item['filetype'] = 'html';

			if (isset($fileType[0]))
			{
				$type = trim($fileType[0]->text);
				$type = str_replace('[', '', $type);
				$type = str_replace(']', '', $type);
				$type = strtolower($type);

				$item['filetype'] = $type;
			}

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
 