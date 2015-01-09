<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Controller\Wos\Engine;

use Csi\Engine\AbstractEngine;
use Windwalker\Controller\Controller;
use Windwalker\Data\Data;
use Windwalker\Data\DataSet;
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

		$result = $engine->getPage();

		if (!isset($result->return->records))
		{
			return 'No result';
		}

		$articles = new DataSet($result->return->records);

		$this->app->triggerEvent('onAfterCountEnginepages', array($task->database, $queue, &$articles, $task, $engine));

		return sprintf('Count pages: %s success.', count($articles));
	}
}
 