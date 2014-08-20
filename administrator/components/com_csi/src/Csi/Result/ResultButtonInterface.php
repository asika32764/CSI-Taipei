<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Result;

use Windwalker\Data\Data;

/**
 * Interface ResultInterface
 *
 * @since  {DEPLOY_VERSION}
 */
interface ResultButtonInterface
{
	/**
	 * render
	 *
	 * @param string $field
	 * @param Data   $item
	 * @param Data   $result
	 * @param int    $i
	 *
	 * @return  mixed
	 */
	public static function render($field, $item, $result, $i);
}
 