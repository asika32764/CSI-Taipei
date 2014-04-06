<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Reader;

class Reader
{
	/**
	 * read
	 *
	 * @param string $file
	 *
	 * @return  mixed|null
	 *
	 * @throws \DomainException
	 */
	public static function read($file)
	{
		// Detect file type
		$filetmp = explode('.', $file);
		$type    = array_pop($filetmp);
		$file    = \JPath::clean(JPATH_ROOT . '/' . $file);

		if (!$type || $type == '')
		{
			return null;
		}

		switch ($type)
		{
			case 'doc' :
			case 'docx' :
				$name = 'doc';
				break;

			case 'ppt' :
			case 'pptx' :
				$name = 'ppt';
				break;

			case 'xls' :
			case 'xlsx' :
				$name = 'xls';
				break;

			case 'pdf' :
				$name = 'pdf';
				break;

			default:
				$name = 'general';
				break;
		}

		$class = 'Csi\\Reader\\' . ucfirst($name) . 'Reader';

		if (!class_exists($class))
		{
			// throw new \DomainException(sprintf('Filetype: %s not support', $name));

			return null;
		}

		return call_user_func_array(array($class, 'read'), array($file, $type));
	}
}
 