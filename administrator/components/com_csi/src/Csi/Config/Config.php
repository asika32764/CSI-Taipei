<?php
/**
 * Part of Component Csi files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Csi\Config;

use Joomla\Registry\Registry;
use Windwalker\System\Config\AbstractConfig;

// No direct access
defined('_JEXEC') or die;

/**
 * Class Config
 *
 * @since 1.0
 */
abstract class Config extends AbstractConfig
{
	/**
	 * Property type.
	 *
	 * @var  string
	 */
	protected static $type = 'yaml';

	/**
	 * getPath
	 *
	 * @return  string
	 */
	public static function getPath()
	{
		$type = static::$type;
		$ext  = (static::$type == 'yaml') ? 'yml' : $type;

		return CSI_ADMIN . '/etc/config.' . $ext;
	}

	/**
	 * Get config from file. Will get from cache if has loaded.
	 *
	 * @return  Registry Config object.
	 */
	public static function getConfig()
	{
		if (static::$config instanceof Registry)
		{
			return static::$config;
		}

		$config = with(new Registry)
			->loadFile(static::getPath(), static::$type)
			->loadFile(CSI_ADMIN . '/etc/wos.yml', 'yaml');

		return static::$config = $config;
	}
}
