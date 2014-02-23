<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Windwalker\Router;

/**
 * Class Route
 *
 * @since 1.0
 */
class Route
{
	/**
	 * Proxy of build()
	 *
	 * @param string  $resource
	 * @param array   $data
	 * @param boolean $xhtml
	 * @param boolean $ssl
	 *
	 * @return  string Route url.
	 */
	public static function _($resource, $data = array(), $xhtml = true, $ssl = null)
	{
		return static::build($resource, $data, $xhtml, $ssl);
	}

	/**
	 * Build route.
	 *
	 * @param string  $resource
	 * @param array   $data
	 * @param boolean $xhtml
	 * @param boolean $ssl
	 *
	 * @return  string Route url.
	 */
	public static function build($resource, $data = array(), $xhtml = true, $ssl = null)
	{
		$router = CmsRouter::getInstance();

		$url = $router->build($resource, $data);

		return \JRoute::_($url, $xhtml, $ssl);
	}
}
 