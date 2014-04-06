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
 * Class PageHelper
 *
 * @since 1.0
 */
class PageHelper
{
	/**
	 * getFilePath
	 *
	 * @param int    $id
	 * @param string $filetype
	 *
	 * @return  string
	 */
	public static function getFilePath($id, $filetype = 'html')
	{
		return static::getFileFolder() . '/' . $id . '.' . $filetype;
	}

	/**
	 * getFileFolder
	 *
	 * @return  string
	 */
	public static function getFileFolder()
	{
		return 'files/pages';
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
 