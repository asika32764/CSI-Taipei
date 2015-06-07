<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Engine;

use Csi\Config\Config;
use Csi\Mendeley\Mendeley;
use Joomla\String\String;
use PHPHtmlParser\Dom;
use Windwalker\Data\Data;

/**
 * Class GoogleEngine
 *
 * @since 1.0
 */
class MendeleyEngine extends AbstractEngine
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
	protected $host = 'https://api.mendeley.com';

	/**
	 * Property path.
	 *
	 * @var  string
	 */
	public $path = '/search/catalog' ;

	/**
	 * Property query.
	 *
	 * @var  array
	 */
	public $query = array(
		'author' => null,
		'view'   => 'all',
		'limit'  => 100,
		'access_token' => null
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
		$uri = $this->prepareUrl($page);

		$queries = $uri->getQuery(true);

		$mendeley = new Mendeley(Config::get('mendeley.id'), Config::get('mendeley.secret'));

		return $mendeley->get('search/catalog', $queries)->body;
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

		$uri->setQuery($this->query) ;
		$uri->setVar('author', $this->state->get('keyword'));
		$uri->setVar('access_token', Config::get('mendeley.token'));

		return $uri;
	}
}
 