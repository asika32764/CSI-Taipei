<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Engine;

use Csi\Helper\RefCurlHelper;
use Joomla\String\String;
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
		'q' 	=> null ,
		'hl' 	=> 'zh-TW' ,
		'ie'    => 'UTF-8',
		'num' 	=> 100 ,
		'filter'=> 0 ,
		'safe' 	=> 'on',
		'start' => null
	) ;

	public function getPageList()
	{
		$page = $this->getPage(1);

		echo $page;die;
	}

	protected function getPage($page = 1)
	{
		if ($page < 1)
		{
			throw new \InvalidArgumentException('Page should bigger than 0.');
		}

		if (!$this->state->get('keyword'))
		{
			return null;
		}

		$uri = new \JUri($this->host);

		$uri->setPath($this->path);

		$text = $this->state->get('keyword');
		$text = trim($text);
		$text = urlencode($text);
		$text = str_replace(array('%20', ' '), '+', $text);

		$uri->setQuery($this->query) ;
		$uri->setVar( 'q', $text );

		// return RefCurlHelper::getPageHTML((string) $uri);
		$page = CurlHelper::get((string) $uri, 'get', null, array(CURLOPT_ENCODING => 'UTF-8'))->body;

		$page = String::transcode($page, 'big5', 'UTF-8');

		return $page;
	}
}
 