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

		$queue = with(new DataMapper('#__csi_queues'))->findOne(array('id' => $id));

		$queue->query = new \JRegistry(json_decode($queue->query));

		$task = with(new DataMapper('#__csi_tasks'))->findOne(array('id' => $queue->query->get('id')));

		if (!(array) $task)
		{
			throw new \RuntimeException('Task not found');
		}

		// Prepare engine model to parse page
		$engine = AbstractEngine::getInstance($task->engine);

		$engine->getState()->set('keyword', $queue->query->get('keyword'));

		$pages = $engine->getPageList();

		$this->app->triggerEvent('onAfterCountEnginepages', array($task->database, $queue, &$pages, $task, $engine));

		return sprintf('Count pages: %s success.', count($pages));
	}
}
 