<?php
/**
 * Part of Component Csi files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Csi\Config;

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
}
