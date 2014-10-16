<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Engine;

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
