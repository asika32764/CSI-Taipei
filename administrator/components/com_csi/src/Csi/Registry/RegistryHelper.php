<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Registry;

/**
 * Class RegistryHelper
 *
 * @since 1.0
 */
class RegistryHelper
{
	/**
	 * loadString
	 *
	 * @param string $string
	 * @param string $type
	 *
	 * @return  \JRegistry
	 */
	public static function loadString($string, $type = 'JSON')
	{
		$registry = new \JRegistry;

		$registry->loadString($string, $type);

		return $registry;
	}

	/**
	 * loadString
	 *
	 * @param string $file
	 * @param string $type
	 *
	 * @return  \JRegistry
	 */
	public static function loadFile($file, $type = 'JSON')
	{
		$registry = new \JRegistry;

		$registry->loadFile($file, $type);

		return $registry;
	}
}
 