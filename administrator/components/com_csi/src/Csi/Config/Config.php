<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Config;

use Joomla\Registry\Registry;

/**
 * Class Config
 *
 * @since 1.0
 */
class Config
{
	/**
	 * Property config.
	 *
	 * @var  Registry
	 */
	public static $config = null;

	/**
	 * get
	 *
	 * @param $name
	 * @param $default
	 *
	 * @return  mixed
	 */
	public static function get($name, $default = null)
	{
		$config = static::getConfig();

		return $config->get($name, $default);
	}

	/**
	 * set
	 *
	 * @param $name
	 * @param $value
	 *
	 * @return  mixed
	 */
	public static function set($name, $value)
	{
		$config = static::getConfig();

		return $config->set($name, $value);
	}

	public static function getConfig()
	{
		if (static::$config)
		{
			return static::$config;
		}

		$config = new Registry;

		$config->loadFile(CSI_ADMIN . '/config.json');

		return static::$config = $config;
	}
}
 