<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Reader;

/**
 * Interface ReaderInterface
 */
interface ReaderInterface
{
	/**
	 * read
	 *
	 * @param string $file
	 * @param string $type
	 *
	 * @return  mixed
	 */
	public static function read($file, $type);
}
 