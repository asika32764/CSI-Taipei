<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Reader;

/**
 * Class DocReader
 *
 * @since 1.0
 */
class DocReader implements ReaderInterface
{
	/**
	 * read
	 *
	 * @param string $file
	 * @param string $type
	 *
	 * @return  mixed
	 */
	public static function read($file, $type)
	{
		return shell_exec("antiword -m UTF-8.txt $file");
	}
}
 