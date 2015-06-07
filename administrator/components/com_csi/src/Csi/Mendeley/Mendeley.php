<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Mendeley;

use Csi\Config\Config;

/**
 * The Mendeley class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class Mendeley
{
	const METHOD_GET = 'get';
	const METHOD_POST = 'post';
	const METHOD_HEAD = 'head';

	/**
	 * Property id.
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * Property secret.
	 *
	 * @var string
	 */
	protected $secret;

	/**
	 * Property host.
	 *
	 * @var  string
	 */
	protected $host = 'https://api.mendeley.com';

	/**
	 * Property token.
	 *
	 * @var  string
	 */
	protected $token = '';

	/**
	 * Class init.
	 *
	 * @param string $id
	 * @param string $secret
	 */
	public function __construct($id, $secret)
	{
		$this->id = $id;
		$this->secret = $secret;
	}

	/**
	 * getToken
	 *
	 * @return  string
	 */
	public function getToken()
	{
		$queries = array(
			'grant_type'    => 'client_credentials',
			'scope'         => 'all',
			'client_id'     => $this->id,
			'client_secret' => $this->secret
		);

		$http = $this->getHttp();

		$uri = new \JUri(rtrim($this->host, '/') . '/oauth/token');

		$response = $http->post($uri->toString(), $queries);

		$response = json_decode($response->body);

		return isset($response->access_token) ? $response->access_token : null;
	}

	public function get($path, $queries = array())
	{
		return $this->execute($path, $queries);
	}

	/**
	 * execute
	 *
	 * @param string $path
	 * @param array  $queries
	 * @param string $method
	 *
	 * @return  \JHttpResponse
	 */
	public function execute($path, $queries = array(), $method = self::METHOD_GET)
	{
		$http = $this->getHttp();

		$uri = new \JUri(rtrim($this->host, '/') . '/' . ltrim($path, '/'));

		$queries['access_token'] = $this->getToken();

		if ($method == static::METHOD_GET)
		{
			foreach ($queries as $key => $val)
			{
				$uri->setVar($key, urlencode($val));
			}

			return $http->get($uri->toString());
		}
		else
		{
			return $http->$method($uri->toString(), $queries);
		}
	}

	/**
	 * getHttp
	 *
	 * @param array $options
	 *
	 * @return  \JHttp
	 */
	public function getHttp($options = null)
	{
		return \JHttpFactory::getHttp($options, 'curl');
	}
}
