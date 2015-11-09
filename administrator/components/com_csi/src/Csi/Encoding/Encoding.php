<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Encoding;

/**
 * The Encoding class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class Encoding
{
	/**
	 * toUtf8
	 *
	 * @param string $text
	 *
	 * @return  string
	 */
	public static function toUtf8($text)
	{
		// Detect encoding
		$encoding = mb_detect_encoding($text);

		// If is BIG5, convert encoding to utf-8
		if ($encoding != 'UTF-8')
		{
			$text = iconv("CP950", "UTF-8//IGNORE", $text);
		}

		return $text;
	}
}
