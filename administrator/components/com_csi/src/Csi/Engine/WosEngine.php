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
	 * @return  object
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
	 * getCited
	 *
	 * @param string $doi
	 *
	 * @return  \SimpleXMLElement
	 */
	public function getCited($doi)
	{
		if (Config::get('database.wos.test'))
		{
			return simplexml_load_string(file_get_contents(CSI_ADMIN . '/test/wos/author.xml'));
		}

		$http = \JHttpFactory::getHttp(null, 'curl');

		$xml = <<<XML
<request xmlns="http://www.isinet.com/xrpc41" src="app.id=PartnerApp,env.id=PartnerAppEnv,partner.email=tingchiang@ntu.edu.tw">
	<fn name="LinksAMR.retrieve">
		<list>
			<map></map>
			<map>
				<list name="WOS">
					<val>timesCited</val>
					<val>sourceURL</val>
					<val>citingArticlesURL</val>
				</list>
			</map>
			<map>
				<map name="84857">
					<val name="doi">{$doi}</val>
				</map>
			</map>
		</list>
	</fn>
</request>
XML;

		$result = $http->post('https://ws.isiknowledge.com/cps/xrpc', $xml, array('Content-Type' => 'text/xml'));

		return simplexml_load_string($result->body);
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
		return parent::prepareUrl($page);
	}
}
 