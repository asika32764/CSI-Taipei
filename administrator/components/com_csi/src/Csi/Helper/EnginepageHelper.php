<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Helper;

use Joomla\Filesystem\File;

/**
 * Class EnginepageHelper
 *
 * @since 1.0
 */
class EnginepageHelper
{
	/**
	 * getFilePath
	 *
	 * @param int $id
	 *
	 * @return  string
	 */
	public static function getFilePath($id)
	{
		return static::getFileFolder() . '/' . $id . '.html';
	}

	/**
	 * getFileFolder
	 *
	 * @return  string
	 */
	public static function getFileFolder()
	{
		return 'files/enginepages';
	}

	/**
	 * saveFile
	 *
	 * @param int    $id
	 * @param string $html
	 *
	 * @return  int
	 */
	public static function saveFile($id, $html)
	{
		$path = static::getFilePath($id);

		if (is_file($path))
		{
			File::delete($path);
		}

		return File::write(JPATH_ROOT . '/' . $path, $html);
	}
}
 