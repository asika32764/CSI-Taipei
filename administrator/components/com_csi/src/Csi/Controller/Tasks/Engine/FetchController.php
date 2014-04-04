<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Controller\Tasks\Engine;

use Csi\Model\EngineModel;
use Windwalker\Controller\Controller;

/**
 * Class FetchController
 *
 * @since 1.0
 */
class FetchController extends Controller
{
	/**
	 * doExecute
	 *
	 * @return mixed
	 */
	protected function doExecute()
	{
		$id = $this->input->get('id');

		$engine = new EngineModel;

		// $engine->fetchPages
	}
}
 