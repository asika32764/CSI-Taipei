<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Listener\Scholar;

use Csi\Config\Config;
use Csi\Database\AbstractDatabase;
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
 * Class SyllabusListener
 *
 * @since 1.0
 */
class ScholarListener extends DatabaseListener
{
	/**
	 * Property type.
	 *
	 * @var  string
	 */
	protected $type = 'scholar';

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
				'enginepage_id' => $data->id,
				'task_id' => $task->id,
				'page' => $lastQueue->query->get('num')
			)
		);

		$queueModel->add('tasks.scholar.count', $query, $task);
	}

	/**
	 * onPageAnalysis
	 *
	 * @param string                $database
	 * @param \Windwalker\Data\Data $page
	 * @param \Windwalker\Data\Data $task
	 *
	 * @return  void
	 */
	public function onPageAnalysis($database, $page, $task)
	{
		if (!$this->checkType($database))
		{
			return;
		}

		// $page is EnginePage
		$path = $page->file;

		if (!is_file($path))
		{
			throw new \RuntimeException(sprintf('File: %s not found', $path));
		}

		$model = AbstractDatabase::getInstance('scholar');

		$html = file_get_contents($path);

		$result = $model->parseResult($html);

		// Save Result
		$this->saveResult($database, $page, $task, $result, 'engine');
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

		foreach ($resultFields as $field)
		{
			$class = sprintf('Csi\\Database\\%s\\%sResult', ucfirst($database), Normalise::toCamelCase($field));

			if (!class_exists($class))
			{
				$app->enqueueMessage($class . ' not exists', 'warning');

				continue;
			}

			$task = $taskMapper->findOne(array('entry_id' => $entry->id, 'database' => $database));

			if ($task->isNull())
			{
				throw new \RuntimeException(sprintf('Can not get task by entry_id: %s and database: %s.', $entry->id, $database));
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
 