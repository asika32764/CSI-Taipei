<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Listener;


class DatabaseListener extends \JEvent
{
	/**
	 * Property type.
	 *
	 * @var  string
	 */
	protected $type = '';

	/**
	 * checkType
	 *
	 * @param string $database
	 *
	 * @return  bool
	 */
	protected function checkType($database)
	{
		if ($database != $this->type)
		{
			return false;
		}

		return true;
	}
}
 