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
use Joomla\String\Normalise;
use Windwalker\Data\Data;
use Windwalker\DI\Container;
use Windwalker\Joomla\DataMapper\DataMapper;

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
	 * @return  void
	 */
	public function onDatabaseGetResult($database, Data $entry, Data $result)
	{
		if (!$this->checkType($database))
		{
			return;
		}

		$app = Container::getInstance()->get('app');

		$resultFields = Config::get('database.' . $database . '.result_fields');

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

			$result->$field = with(new $class($task))->get();
		}
	}
}
 