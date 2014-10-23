<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Engine;

use Joomla\String\String;
use Windwalker\Helper\CurlHelper;

/**
 * The TciEngine class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class TciEngine extends AbstractEngine
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
	protected $host = 'http://tci.ncl.edu.tw/';

	/**
	 * Property path.
	 *
	 * @var  string
	 */
	public $path = '/cgi-bin/gs32/gsweb.cgi/ccd=XJYgTf/tcisearch_opt1_search' ;

	/**
	 * Property query.
	 *
	 * @var  array
	 */
	public $query = array(
		'qs0'     => null,
//		'hl'    => 'zh-TW' ,
//		'ie'    => 'UTF-8',
//		'num'   => 100 ,
//		'filter'=> 0 ,
//		'safe'  => 'on',
//		'start' => null
	);

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

		echo $uri;die;

		$queries;

		// return RefCurlHelper::getPageHTML((string) $uri);
		$html = CurlHelper::get((string) $uri, 'post', $queries, array(CURLOPT_ENCODING => 'UTF-8'))->body;

		$html = String::transcode($html, 'big5', 'UTF-8');

		return $html;
	}

	/**
	 * getPageList
	 *
	 * @return  \Windwalker\Data\Data[]
	 */
	public function getPageList()
	{

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

	}
}
