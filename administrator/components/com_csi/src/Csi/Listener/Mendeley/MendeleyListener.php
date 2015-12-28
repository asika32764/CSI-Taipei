<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Listener\Mendeley;

use Csi\Config\Config;
use Csi\Database\AbstractDatabase;
use Csi\Engine\AbstractEngine;
use Csi\Helper\KeywordHelper;
use Csi\Listener\DatabaseListener;
use Csi\Model\QueueModel;
use Csi\Reader\Reader;
use Csi\Result\ResultHelper;
use Csi\Table\Table;
use Joomla\String\Normalise;
use Windwalker\Data\Data;
use Windwalker\DI\Container;
use Windwalker\Joomla\DataMapper\DataMapper;
use Windwalker\View\Layout\FileLayout;

/**
 * Class WosListener
 *
 * @since 1.0
 */
class MendeleyListener extends DatabaseListener
{
	/**
	 * Property type.
	 *
	 * @var  string
	 */
	protected $type = 'mendeley';

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
	public function onBeforeTaskSave($database, $engine, $id, Data $data)
	{
		if (!$this->checkType($database))
		{
			return;
		}

		/** @var \Csi\Database\MendeleyDatabase $task */
		$task = AbstractDatabase::getInstance($this->type);

		$data->keyword = $task->getKeyword($data);
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

		$query = new \JRegistry(
			array(
				'id' => $id,
				'keyword' => $data->keyword
			)
		);

		$model = new QueueModel;

		$model->add('mendeley.cited.analysis', $query, $data);
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
			$query->set('keyword', $lastQueue->query->get('keyword'));
			$query->set('page.uid', $page['uid']);
			$query->set('page.title', $page->title->value);
			$query->set('page.doi', isset($page->other[3]->value) ? $page->other[3]->value : null);

			$queueModel->add('wos.cited.analysis', $query, $task);
		}
	}

	/**
	 * onPageAnalysis
	 *
	 * @param integer $result
	 * @param Data    $task
	 *
	 * @return  void
	 */
	public function onMendeleyAfterAnalysis($result, Data $task)
	{
		// Save Result
		$this->saveResult('mendeley', new Data, $task, new Data(['cited' => $result]), 'engine');
	}

	/**
	 * onDatabaseGetResult
	 *
	 * @param string $database
	 * @param Data   $entry
	 * @param Data   $result
	 *
	 * @throws  \RuntimeException
	 * @return  void
	 */
	public function onDatabaseGetResult($database, Data $entry, Data $result)
	{
		if (!$this->checkType($database))
		{
			return;
		}

		$app = Container::getInstance()->get('app');

		$resultFields = Config::get('database.' . $database . '.result_fields', array());

		$taskMapper = new DataMapper('#__csi_tasks');

		$task = $taskMapper->findOne(array('entry_id' => $entry->id, 'database' => $database));

		if ($task->isNull())
		{
			throw new \RuntimeException(sprintf('Can not get task by entry_id: %s and database: %s.', $entry->id, $database));
		}

		foreach ($resultFields as $field)
		{
			$class = sprintf('Csi\\Database\\%s\\%sResult', ucfirst($database), Normalise::toCamelCase($field));

			if (!class_exists($class))
			{
				$app->enqueueMessage($class . ' not exists', 'warning');

				continue;
			}

			$result->$field = with(new $class($task))->get() ? : 0;
		}
	}

	/**
	 * onPrepareResult
	 *
	 * @param string $database
	 * @param string $field
	 * @param Data   $item
	 * @param Data   $result
	 * @param int    $i
	 *
	 * @return  void
	 */
	public function onPreparePageResult($database, $field, $item, $result, $i)
	{
		if (!$this->checkType($database))
		{
			return;
		}

		$resultHandler = ResultHelper::getHandler($field);

		$item->results->$field = $resultHandler::render($field, $item, $result, $i);
	}

	/**
	 * onAfterResultUpdate
	 *
	 * @param string $database
	 * @param Data   $page
	 * @param string $field
	 * @param mixed  $value
	 *
	 * @return  void
	 */
	public function onAfterResultUpdate($database, $page, $field, $value)
	{
		if (!$this->checkType($database))
		{
			return;
		}

//		if ($field == 'is_syllabus' && $value == 0)
//		{
//			with(new DataMapper('#__csi_results'))
//				->updateAll(new Data(array('value' => 0)), array('fk' => $page->id));
//		}
//
//		if (($field == 'cited' || $field == 'self_cited') && $value == 1)
//		{
//			with(new DataMapper('#__csi_results'))
//				->updateAll(new Data(array('value' => 1)), array('fk' => $page->id, 'key' => 'is_syllabus'));
//		}
	}
}
 