<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Helper;

use Csi\Config\Config;
use Windwalker\View\Layout\FileLayout;

/**
 * Class DatabaseHelper
 *
 * @since 1.0
 */
class DatabaseHelper
{
	/**
	 * generateCheckboxes
	 *
	 * @param array $actives
	 *
	 * @return  string
	 */
	public static function generateCheckboxes($actives = array())
	{
		$databases = Config::get('database');

		$databases = array_keys((array) $databases);

		return with(new FileLayout('databases.checkboxes'))->render(
				array(
					'databases' => $databases,
					'actives' => $actives
				)
			);
	}
}
 