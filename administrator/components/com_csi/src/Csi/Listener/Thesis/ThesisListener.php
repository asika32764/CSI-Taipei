<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Csi\Listener\Thesis;

use Csi\Config\Config;
use Csi\Database\AbstractDatabase;
use Csi\Listener\DatabaseListener;
use Joomla\String\Normalise;
use Windwalker\Data\Data;
use Windwalker\DI\Container;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * The ThesisListener class.
 *
 * @since  {DEPLOY_VERSION}
 */
class ThesisListener extends DatabaseListener
{
	/**
	 * Property type.
	 *
	 * @var  string
	 */
	protected $type = 'thesis';

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

		$keyword = json_decode($data->keyword, true);

		// Prepare others
		$queueModel = new \Csi\Model\QueueModel;

		$query = new \JRegistry(
			array(
				'id' => $id,
				'keyword' => $keyword,
				'engine' => 'ethesys'
			)
		);

		$queueModel->add('thesis.cited.analysis', $query, $data);

		$query = new \JRegistry(
			array(
				'id' => $id,
				'keyword' => $keyword,
				'engine' => 'ethesys'
			)
		);

		$queueModel->add('thesis.advisor.analysis', $query, $data);

		$query = new \JRegistry(
			array(
				'id' => $id,
				'keyword' => $keyword,
				'engine' => 'airiti'
			)
		);

		$queueModel->add('thesis.advisor.analysis', $query, $data);
	}

	/**
	 * onEthesysAfterAnalysis
	 *
	 * @param int    $result
	 * @param Data   $task
	 */
	public function onThesisAfterCitedAnalysis($result, Data $task)
	{
		// Save Result
		$this->saveResult('ethesys', new Data, $task, new Data(['cited' => $result]), 'engine');
	}

	/**
	 * onThesisAfterAdvisorAnalysis
	 *
	 * @param int    $result
	 * @param Data   $task
	 * @param string $engine
	 *
	 * @return  void
	 */
	public function onThesisAfterAdvisorAnalysis($result, Data $task, $engine)
	{
		// Save Result
		$this->saveResult($engine, new Data, $task, new Data([$engine . '_advisor' => $result]), 'engine');
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
}
