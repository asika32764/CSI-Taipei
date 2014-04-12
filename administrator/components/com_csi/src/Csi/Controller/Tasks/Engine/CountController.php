<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Controller\Tasks\Engine;

use Csi\Engine\AbstractEngine;
use Csi\Model\QueueModel;
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
	 * @throws \RuntimeException
	 * @return mixed
	 */
	protected function doExecute()
	{
		$id = $this->input->get('id');

		if (!$id)
		{
			return false;
		}

		$task = with(new DataMapper('#__csi_tasks'))->findOne(array('id' => $id));

		if (!(array) $task)
		{
			throw new \RuntimeException('Task not found');
		}

		// Prepare engine model to parse page
		$engine = AbstractEngine::getInstance($task->engine);

		$engine->getState()->set('keyword', $task->keyword);

		$pages = $engine->getPageList();

		// Get Queue model
		$queueModel = new QueueModel;

		// Build query
		$query = new \JRegistry;

		$query->set('id', $task->id);

		foreach ($pages as $page)
		{
			$query->set('url', $page->url);
			$query->set('num', $page->num);
			$query->set('total', count($pages));
			$query->set('keyword', $task->keyword);

			$queueModel->add('tasks.engine.fetch', $query, $task);
		}

		$msg = sprintf('Count pages: %s success.', count($pages));

		exit($msg);
	}
}
 