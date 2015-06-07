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
	 * Make First Last name to: ["First Last", "Last, First"]
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

		return static::buildNameConditions($names);
	}

	/**
	 * Implode all names to '"A" OR "B" OR "C"'
	 *
	 * @param array $names
	 *
	 * @return  string
	 */
	public static function buildNameConditions($names)
	{
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

	/**
	 * encode
	 *
	 * @param string $text
	 *
	 * @return  mixed
	 */
	public static function encode($text)
	{
		$text = trim($text);
		$text = urlencode($text);

		return str_replace(array('%20', ' '), '+', $text);
	}
}
 