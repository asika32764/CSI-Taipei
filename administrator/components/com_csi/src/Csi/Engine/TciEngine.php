<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Engine;

use Csi\Database\TciDatabase;
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
	public $path = '/cgi-bin/gs32/gsweb.cgi/ccd=%s/tcisearch_opt1_search' ;

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

	protected $queries = [
		TciDatabase::TYPE_AUTHOR => [
			'maylimitonly' => 1,
			'mtstype' => ['期刊論文', '博士論文', '專書', '專書論文', 'ALL'],
			'displayonerecdisable' => 1,
			'extrasearch' => 'es0',
			'ltsysbc' => 2000,
			'histlist' => 1,
			'_status_' => 'tcisearch_opt1'
		],
		TciDatabase::TYPE_CITED => [
			'qs0' => null,
			'dcf' => 'au',
			'displayonerecdisable' => 1,
			'extrasearch' => 'es0',
			'_status_' => 'tcisearch_opt2'
		]
	];

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

		\JFolder::create(JPATH_ROOT . '/tmp/cookie');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://tci.ncl.edu.tw/cgi-bin/gs32/gsweb.cgi?o=dnclresource&tcihsspage=tcisearcharea&loadingjs=1&ssoauth=1&cache=' . time());
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, JPATH_ROOT . '/tmp/cookie/tci');
		curl_setopt($ch, CURLOPT_COOKIEFILE, JPATH_ROOT . '/tmp/cookie/tci');
		$answer = curl_exec($ch);
		if (curl_error($ch))
		{
			throw new \RuntimeException(curl_error($ch));
		}

		preg_match('/ccd=([\w]*)/i', $answer, $matched);

		$ccd  = $matched[1];
		$type = $this->state->get('type', TciDatabase::TYPE_AUTHOR);
		$queries = $this->queries[$type];

		$keywords = json_decode($this->state->get('keyword', '[]'));

		foreach ($keywords as $i => $keyword)
		{
			$queries['qs' . $i] = $keyword;
			$queries['qf' . $i] = 'au';
			$queries['qo' . ($i + 1)] = 'or';
		}

		curl_setopt($ch, CURLOPT_URL, 'http://tci.ncl.edu.tw/cgi-bin/gs32/gsweb.cgi/ccd=' . $ccd . '/' . $queries['_status_'] .'_search#result');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($queries));
		$html = curl_exec($ch);
		if (curl_error($ch))
		{
			throw new \RuntimeException(curl_error($ch));
		}

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
