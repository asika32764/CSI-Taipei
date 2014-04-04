<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Database;

use Windwalker\Data\Data;

/**
 * Class SyllabusDatabase
 *
 * @since 1.0
 */
class SyllabusDatabase extends AbstractDatabase
{
	public function getKeyword(Data $task)
	{
		$title = $task->title;

		return $title;
	}
}
 