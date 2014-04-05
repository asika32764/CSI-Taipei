<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Model;

use Windwalker\Data\Data;

/**
 * Class EngineModel
 *
 * @since 1.0
 */
class EngineModel extends \JModelDatabase
{
	/**
	 * savePage
	 *
	 * @param Data   $data
	 * @param string $engine
	 *
	 * @return  boolean
	 */
	public function savePage($html, $path)
	{
		$data->query = new \JRegistry($data->query);

		// $engine =
	}
}
 