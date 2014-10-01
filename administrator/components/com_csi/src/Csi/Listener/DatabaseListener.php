<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Listener;

use Csi\Model\QueueModel;
use Windwalker\Data\Data;
use Windwalker\Joomla\DataMapper\DataMapper;

class DatabaseListener extends \JEvent
{
	/**
	 * Property type.
	 *
	 * @var  string
	 */
	protected $type = '';

	/**
	 * checkType
	 *
	 * @param string $database
	 *
	 * @return  bool
	 */
	protected function checkType($database)
	{
		if ($database != $this->type)
		{
			return false;
		}

		return true;
	}

	/**
	 * onBeforeTaskSave
	 *
	 * @param string                $database
	 * @param string                $engine
	 * @param int                   $id
	 * @param \Windwalker\Data\Data $data
	 *
	 * @return  void
	 */
	public function onAfterTaskSave($database, $engine, $id, Data $data)
	{
		if (!$this->checkType($database))
		{
			return;
		}

		// Get queue model to add queue
		$model = new QueueModel;

		$query = new \JRegistry(
			array(
				'id' => $id,
				'keyword' => $data->keyword
			)
		);

		$model->add('tasks.engine.count', $query, $data);
	}

	/**
	 * onAfterCountEnginepages
	 *
	 * @param string $database
	 * @param Data   $lastQueue
	 * @param Data   $pages
	 * @param Data   $task
	 * @param Data   $engine
	 *
	 * @return  void
	 */
	public function onAfterCountEnginepages($database, $lastQueue, $pages, $task, $engine)
	{
		if (!$this->checkType($database))
		{
			return;
		}

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
			$query->set('keyword', $lastQueue->query->get('keyword'));

			$queueModel->add('tasks.engine.fetch', $query, $task);
		}
	}

	/**
	 * onAfterPageFetch
	 *
	 * @param string $database
	 * @param Data   $lastQueue
	 * @param Data   $data
	 * @param Data   $task
	 * @param Data   $engine
	 *
	 * @return  void
	 */
	public function onAfterFetchPage($database, $lastQueue, Data $data, $task, $engine)
	{
		if (!$this->checkType($database))
		{
			return;
		}

		// Add queue to parse
		$queueModel = new QueueModel;

		$query = new \JRegistry(
			array(
				'id' => $data->id,
				'task_id' => $task->id,
				'page' => $lastQueue->query->get('num')
			)
		);

		$queueModel->add('tasks.engine.parse', $query, $task);
	}

	/**
	 * saveResult
	 *
	 * @param string                $database
	 * @param \Windwalker\Data\Data $page
	 * @param \Windwalker\Data\Data $task
	 * @param \Windwalker\Data\Data $result
	 *
	 * @return  boolean
	 */
	protected function saveResult($database, Data $page, Data $task, Data $result)
	{
		$mapper = new DataMapper('#__csi_results');

		foreach ($result as $key => $value)
		{
			$data = new Data;

			$data->entry_id = $task->entry_id;
			$data->task_id  = $task->id;
			$data->type = 'page';
			$data->fk = $page->id;
			$data->key = $key;
			$data->value = $value;

			$data = $mapper->createOne($data);
		}
	}
}
 