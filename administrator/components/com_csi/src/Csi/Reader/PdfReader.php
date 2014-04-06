<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Reader;

/**
 * Class PdfReader
 *
 * @since 1.0
 */
class PdfReader implements ReaderInterface
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
		$filetmp = explode('.', $file);
		$type    = array_pop($filetmp);
		$filetmp = implode('.', $filetmp);

		shell_exec("/usr/bin/pdftotext {$file} {$filetmp}.txt");

		$output = file_get_contents("{$filetmp}.txt");

		return $output;
	}
}
 