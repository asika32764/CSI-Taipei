<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Csi\Engine;

use Csi\Config\Config;
use Windwalker\Data\Data;

/**
 * The ScopusEngine class.
 *
 * @since  {DEPLOY_VERSION}
 */
class ScopusEngine extends AbstractEngine
{
	/**
	 * Property host.
	 *
	 * @var  string
	 */
	protected $host = 'http://api.elsevier.com';

	/**
	 * Property path.
	 *
	 * @var  string
	 */
	public $path = '/content/search/scopus';

	/**
	 * Property query.
	 *
	 * @var  array
	 */
	public $query = array(
		'apiKey' => null,
		'query' => null,
		'start' => 0
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
	 * prepareUrl
	 *
	 * @param int $page
	 *
	 * @return  \JUri
	 */
	public function prepareUrl($page = 1)
	{
		$uri = parent::prepareUrl($page);

		$uri->setQuery(array(
			'apiKey' => Config::get('scopus.key'),
			'query' => $this->state->get('keyword'),
			'start' => $this->state->get('start', 0)
		));

		return $uri;
	}

	/**
	 * getCited
	 *
	 * @return  \SimpleXMLElement
	 */
	public function getCited()
	{
		$result = json_decode($this->getPage());

		if (!isset($result->{'search-results'}->entry))
		{
			return 0;
		}

		$cited = 0;

		foreach ((array) $result->{'search-results'}->entry as $item)
		{
			$cited += $item->{'citedby-count'};
		}

		return $cited;
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
}
