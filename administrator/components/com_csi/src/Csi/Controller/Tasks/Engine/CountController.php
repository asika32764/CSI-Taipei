<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Controller\Tasks\Engine;

use Csi\Engine\AbstractEngine;
use Windwalker\Controller\Controller;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * Class CountController
 *
 * @since 1.0
 */
class CountController extends Controller
{
	/**
	 * doExecute
	 *
	 * @return mixed
	 */
	protected function doExecute()
	{
		$id = $this->input->get('id');

		$task = with(new DataMapper('#__csi_tasks'))->findOne($id);

		$engine = AbstractEngine::getInstance($task->engine);

		$engine->getPageList();

		show($task, $engine);

		die;
	}
}
 