<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Helper;

use Windwalker\String\String;

/**
 * Class KeywordHelper
 *
 * @since 1.0
 */
class KeywordHelper
{
	/**
	 * arrangeNames
	 *
	 * @param array  $engNames
	 *
	 * @return  array
	 */
	public static function arrangeEngNames($engNames)
	{
		$names = array();

		foreach ($engNames as $engName)
		{
			$engName = (array) $engName;

			$first = \JArrayHelper::getValue($engName, 'first');
			$last  = \JArrayHelper::getValue($engName, 'last');

			$name1 = trim($first . ' ' . $last);
			$name2 = trim($last . ', ' . $first, ' ,');

			$names[] = $name1;
			$names[] = $name2;
		}

		return $names;
	}

	/**
	 * arrangeNames
	 *
	 * @param string $chineseName
	 * @param array  $engNames
	 *
	 * @return  array
	 */
	public static function arrangeNames($chineseName, $engNames)
	{
		$names = static::arrangeEngNames($engNames);

		array_unshift($names, $chineseName);

		return $names;
	}

	/**
	 * buildNamesKeyword
	 *
	 * @param string $chineseName
	 * @param array  $engNames
	 *
	 * @return  string
	 */
	public static function buildNamesKeyword($chineseName, $engNames)
	{
		$names = static::arrangeNames($chineseName, $engNames);

		// Quote names
		$names = array_map(
			function($value)
			{
				return String::quote($value, '"');
			},
			$names
		);

		return trim(implode(' OR ', $names));
	}
}
 