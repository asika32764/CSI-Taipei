<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Listener;


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

			show($data);
		}


	}
}
 