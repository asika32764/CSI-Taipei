<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Helper;

use Joomla\String\Normalise;
use Joomla\String\String;

/**
 * Class EntryHelper
 *
 * @since 1.0
 */
class EntryHelper
{
	public static function regularizeTitle($chineseName, $engNames)
	{
		$chineseName = trim($chineseName);

		$names = array($chineseName);

		foreach ($engNames as $engName)
		{
			$first = \JArrayHelper::getValue($engName, 'first');
			$last  = \JArrayHelper::getValue($engName, 'last');

			$first = static::regularizeEngName($first);
			$last  = static::regularizeEngName($last);

			if (!in_array($first, $names))
			{
				$names[] = $first;
			}

			if (!in_array($last, $names))
			{
				$names[] = $last;
			}
		}

		return implode(';', $names);
	}

	public static function regularizeEngName($name)
	{
		// Trim
		$name = trim($name);

		// Capital
		$name = Normalise::toSpaceSeparated($name);

		$name = String::ucwords($name);

		$name = Normalise::toDashSeparated($name);

		return $name;
	}
}
 