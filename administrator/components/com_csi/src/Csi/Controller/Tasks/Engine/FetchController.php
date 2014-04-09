<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Controller\Tasks\Engine;

use Csi\Engine\AbstractEngine;
use Csi\Helper\EnginepageHelper;
use Csi\Model\QueueModel;
use Windwalker\Controller\Controller;
use Windwalker\Data\Data;
use Windwalker\Helper\DateHelper;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * Class FetchController
 *
 * @since 1.0
 */
class FetchController extends Controller
{
	/**
	 * Property engine.
	 *
	 * @var AbstractEngine
	 */
	protected $engine;

	/**
	 * Property queue.
	 *
	 * @var \Windwalker\Data\Data
	 */
	protected $queue;

	/**
	 * Property task.
	 *
	 * @var \Windwalker\Data\Data
	 */
	protected $task;

	/**
	 * Property query.
	 *
	 * @var \JRegistry
	 */
	protected $query;

	/**
	 * prepareExecute
	 *
	 * @return  void
	 *
	 * @throws \RuntimeException
	 */
	protected function prepareExecute()
	{
		parent::prepareExecute();

		$id = $this->input->get('id');

		$queue = with(new DataMapper('#__csi_queues'))->findOne(array('id' => $id));

		if (!(array) $queue)
		{
			throw new \RuntimeException('Queue: ' . $id . ' Not exists');
		}

		$queue->query = new \JRegistry($queue->query);

		$task = with(new DataMapper('#__csi_tasks'))->findOne(array('id' => $queue->query->get('id')));

		if (!(array) $task)
		{
			throw new \RuntimeException('Task: ' . $queue->query->get('id') . ' Not exists');
		}

		// Prepare engine model to get pages
		$engine = AbstractEngine::getInstance($task->engine);

		$this->task   = $task;
		$this->queue  = $queue;
		$this->engine = $engine;
		$this->query  = $queue->query;
	}

	/**
	 * doExecute
	 *
	 * @throws \Exception
	 * @return mixed
	 */
	protected function doExecute()
	{
		$this->engine->getState()->set('keyword', $this->query->get('keyword'));

		$page = $this->engine->getPage($this->query->get('num'));

		$data = new Data;

		$data->entry_id = $this->task->entry_id;
		$data->task_id  = $this->task->id;
		$data->engine   = $this->task->engine;
		$data->url      = $this->query->get('url');
		$data->total    = $this->query->get('total');
		$data->ordering = $this->query->get('num');
		$data->created  = (string) DateHelper::getDate();

		/** @var $db \JDatabaseDriver */
		$db = $this->container->get('db');

		try
		{
			$db->transactionStart(true);

			$mapper = new DataMapper('#__csi_enginepages');

			// Save Enginepage record
			$data = $mapper->createOne($data);

			// Save html file
			EnginepageHelper::saveFile($data->id, $page);

			// Save file path to DB
			$data->file = EnginepageHelper::getFilePath($data->id);

			$mapper->updateOne($data);

			// Add queue to parse
			$queueModel = new QueueModel;

			$query = new \JRegistry(
				array(
					'id' => $data->id,
					'task_id' => $this->task->id,
					'page' => $page
				)
			);

			$queueModel->add('tasks.engine.parse', $query, $this->task);
		}
		catch (\Exception $e)
		{
			$db->transactionRollback(true);

			throw $e;
		}

		$db->transactionCommit(true);

		$msg = sprintf('Save Engine page success. ID: %s , File: %s', $data->id, $data->file);

		exit($msg);
	}
}
 