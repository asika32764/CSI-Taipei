<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Result;

use Windwalker\Data\Data;
use Windwalker\View\Layout\FileLayout;

/**
 * The CitedResult class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class CitedResultButton implements ResultButtonInterface
{
	/**
	 * render
	 *
	 * @param string $field
	 * @param Data   $item
	 * @param Data   $result
	 * @param int    $i
	 *
	 * @return  mixed|void
	 */
	public static function render($item, $field, $result, $i)
	{
		return with(new FileLayout('pages.result.button'))
			->render(
				array(
					'result' => $result,
					'item'   => $item,
					'i'      => $i
				)
			);
	}
}
 