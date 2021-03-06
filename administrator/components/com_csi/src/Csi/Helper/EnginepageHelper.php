<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Helper;

use Joomla\Filesystem\File;
use Windwalker\Data\Data;
use Windwalker\Joomla\DataMapper\DataMapper;

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
	 * @param mixed $page
	 *
	 * @throws \RuntimeException
	 * @return  string
	 */
	public static function getFilePath($page)
	{
		if (is_numeric($page))
		{
			$page = with(new DataMapper('#__csi_enginepages'))->findOne(array('id' => $page));
		}

		if (!($page instanceof Data))
		{
			throw new \RuntimeException('EnginePage not found.');
		}

		return static::getFileFolder() . '/' . $page->entry_id . '/' . $page->id . '.html';
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
 