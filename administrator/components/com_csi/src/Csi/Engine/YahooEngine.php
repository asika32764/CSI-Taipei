<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Engine;

use Csi\Helper\KeywordHelper;
use Windwalker\Data\Data;
use Windwalker\Helper\CurlHelper;
use Windwalker\String\String;

/**
 * The YahooEngine class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class YahooEngine extends AbstractEngine
{/**
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
	protected $host = 'https://tw.search.yahoo.com';

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
		'p'     => null ,
//		'hl'    => 'zh-TW' ,
//		'ie'    => 'UTF-8',
//		'num'   => 100 ,
//		'filter'=> 0 ,
		// 'safe'  => 'on',
//		'start' => null
	);

	/**
	 * getPageList
	 *
	 * @return  array
	 */
	public function getPageList()
	{
		return array();
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

		// Prepare keyword
		$text = KeywordHelper::encode($this->state->get('keyword'));

		$uri->setQuery($this->query) ;
		$uri->setVar('p', $text);

		$uri->setVar('start' , ($page - 1) * $this->links);

		return $uri;
	}
}
 