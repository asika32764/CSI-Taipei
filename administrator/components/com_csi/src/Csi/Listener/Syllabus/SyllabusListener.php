<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Listener\Syllabus;

use Csi\Config\Config;
use Csi\Database\AbstractDatabase;
use Csi\Helper\KeywordHelper;
use Csi\Listener\DatabaseListener;
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
class SyllabusListener extends DatabaseListener
{
	/**
	 * Property type.
	 *
	 * @var  string
	 */
	protected $type = 'syllabus';

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

		$model = AbstractDatabase::getInstance($database);

		$txt = Reader::read($page->filepath);

		$state = $model->getState();

		// Prepare professors names
		$params = new \JRegistry(json_decode($task->params));

		$names = KeywordHelper::arrangeNames($params->get('name.chinese'), $params->get('name.eng'));

		// Prepare states
		$state->set('professors.titles', Config::get('database.syllabus.analysis.professors.titles'));
		$state->set('professors.names',  $names);
		$state->set('ranges.units',      Config::get('database.syllabus.analysis.units'));
		$state->set('terms.course',      Config::get('database.syllabus.analysis.terms.course'));
		$state->set('terms.reference',   Config::get('database.syllabus.analysis.terms.reference'));

		// Get result
		$result = $model->parseResult($txt);

		// Save Result
		$this->saveResult($database, $page, $task, $result);
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
 