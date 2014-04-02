<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Windwalker\Router;

/**
 * Class CmsRouter
 *
 * @since 1.0
 */
class CmsRouter extends Router
{
	/**
	 * Property instance.
	 *
	 * @var  CmsRouter
	 */
	static protected $instance = array();

	/**
	 * Singleton.
	 *
	 * @param $option
	 *
	 * @return  CmsRouter
	 */
	public static function getInstance($option)
	{
		if (empty(self::$instance[$option]))
		{
			$input = \JFactory::getApplication()->input;

			self::$instance[$option] = new CmsRouter($input);
		}

		return self::$instance[$option];
	}

	/**
	 * Find and execute the appropriate view name based on a given route.
	 *
	 * @param   string  $route  The route string for which to find a view.
	 *
	 * @return  mixed   The return value of the view name.
	 */
	public function getView($route)
	{
		// Get the view name based on the route patterns and requested route.
		return $name = $this->parseRoute($route);
	}
}
