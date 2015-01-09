<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Engine;

use Csi\Config\Config;
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
class WosEngine extends AbstractEngine
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
	);

	/**
	 * getPageList
	 *
	 * @return  \Windwalker\Data\Data[]
	 */
	public function getPageList()
	{
		// No actions
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
		if (Config::get('database.wos.test'))
		{
			return json_decode(file_get_contents(CSI_ADMIN . '/test/wos/search.json'));
		}

		$authUrl  = "http://search.webofknowledge.com/esti/wokmws/ws/WOKMWSAuthenticate?wsdl";
		$authClient = @new \SoapClient($authUrl);
		$authResponse = $authClient->authenticate();

		$searchUrl = "http://search.webofknowledge.com/esti/wokmws/ws/WokSearchLite?wsdl";
		$searchClient = @new \SoapClient($searchUrl, array('trace' => 1));
		$searchClient->__setCookie('SID',$authResponse->return);

		$search_array = array(
			'queryParameters' => array(
				'databaseId' => 'WOS',
				'userQuery' => $this->state->get('keyword'),
				'editions' => array(
					array('collection' => 'WOS', 'edition' => 'SSCI'),
					array('collection' => 'WOS', 'edition' => 'SCI')
				),
				'queryLanguage' => 'en'
			),
			'retrieveParameters' => array(
				'count' => '100',
				'sortField' => array(
					'name' => 'TC',
					'sort' => 'D'
				),
				'viewField' => array(
					'collectionName' => 'WOS',
					array('fieldName' => 'titles')
				),
				'firstRecord' => '1'
			)
		);

		$searchResponse = $searchClient->search($search_array);

		return $searchResponse;
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
		$uri->setVar('q', $this->state->get('keyword'));

		$uri->setVar('start' , ($page - 1) * $this->links);

		return $uri;
	}
}
 