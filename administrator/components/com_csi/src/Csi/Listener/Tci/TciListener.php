<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Listener\Tci;

use Csi\Config\Config;
use Csi\Database\AbstractDatabase;
use Csi\Helper\KeywordHelper;
use Csi\Listener\DatabaseListener;
use Csi\Model\QueueModel;
use Csi\Reader\Reader;
use Csi\Result\ResultHelper;
use Joomla\String\Normalise;
use Windwalker\Data\Data;
use Windwalker\DI\Container;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * Class SyllabusListener
 *
 * @since 1.0
 */
class TciListener extends DatabaseListener
{
	/**
	 * Property type.
	 *
	 * @var  string
	 */
	protected $type = 'tci';

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

		// Get queue model to add queue
		$model = new QueueModel;

		$query = new \JRegistry(
			array(
				'id' => $id,
				'keyword' => $data->keyword
			)
		);

		// Cited
		$model->add('tasks.engine.count', $query, $data);

		// Author
		$model->add('tci.author.count', $query, $data);
	}

	/**
	 * onAfterTciCountAuthor
	 *
	 * @param string  $database
	 * @param Data    $task
	 * @param integer $result
	 *
	 * @return  void
	 */
	public function onAfterTciCountAuthor($database, Data $task, $result)
	{
		if (!$this->checkType($database))
		{
			return;
		}

		$this->saveResult($database, $task, $task, new Data(['author' => $result]), 'engine');
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

			$queueModel->add('tci.cited.analysis', $query, $task);
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
	public function onTciAfterAnalysis($result, Data $task)
	{
		// Save Result
		$this->saveResult('tci', new Data, $task, new Data(['cited' => $result]), 'engine');
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

			$result->$field = with(new $class($task))->get();
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
 