<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Engine;

use Windwalker\Helper\CurlHelper;
use Windwalker\String\String;

/**
 * Class AbstractEngine
 *
 * @since 1.0
 */
abstract class AbstractEngine extends \JModelDatabase
{
	/**
	 * Property pages.
	 *
	 * @var  int
	 */
	public $pages = 0;

	/**
	 * Property links.
	 *
	 * @var  int
	 */
	public $links = 0;

	/**
	 * Property host.
	 *
	 * @var  string
	 */
	protected $host = '';

	/**
	 * Property path.
	 *
	 * @var  string
	 */
	public $path = '';

	/**
	 * Property query.
	 *
	 * @var  array
	 */
	public $query = array();

	/**
	 * getInstance
	 *
	 * @param string $name
	 *
	 * @return  AbstractEngine
	 */
	public static function getInstance($name)
	{
		$class = sprintf('Csi\\Engine\\%sEngine', ucfirst($name));

		return new $class;
	}

	/**
	 * getPageList
	 *
	 * @return  \Windwalker\Data\Data[]
	 */
	abstract public function getPageList();

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

		// $html = String::transcode($html, 'big5', 'UTF-8');

		return $html;
	}

	/**
	 * parsePage
	 *
	 * @param string $html
	 *
	 * @return  \Windwalker\Data\Data[]
	 */
	abstract public function parsePage($html = null);

	/**
	 * prepareUrl
	 *
	 * @param int $page
	 *
	 * @return  \JUri
	 */
	public function prepareUrl($page = 1)
	{
		$uri = new \JUri($this->host);

		$uri->setPath($this->path);

		return $uri;
	}
}
 