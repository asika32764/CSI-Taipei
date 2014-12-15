<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

use Windwalker\Data\DataSet;
use Windwalker\Model\CrudModel;

/**
 * Class CsiModelEntry
 *
 * @since 1.0
 */
class CsiModelEntry extends CrudModel
{
	/**
	 * Property tasks.
	 *
	 * @var \Windwalker\Data\Data
	 */
	protected $tasks = null;

	/**
	 * getResult
	 *
	 * @return  array
	 */
	public function getResult()
	{
		$dispatcher = $this->container->get('event.dispatcher');
		$databases  = $this->state->get('databases', array());
		$entry = new \Windwalker\Data\Data($this->getItem());

		// Get Database results
		$results = array();

		foreach ($databases as $database)
		{
			$result = new \Windwalker\Data\Data;

			$dispatcher->trigger('onDatabaseGetResult', array($database, $entry, $result));

			$results[$database] = $result;
		}

		return $results;
	}

	/**
	 * getTasks
	 *
	 * @return  \Windwalker\Data\Data
	 */
	public function getTasks()
	{
		if ($this->tasks)
		{
			return $this->tasks;
		}

		$entryId = $this->state->get('entry.id');

		$query = $this->db->getQuery(true);

		$query->select('*')
			->from('#__csi_tasks')
			->where($query->format('%n = %q', 'entry_id', $entryId));

		$tasks = $this->db->setQuery($query)->loadObjectList('database');

		foreach ($tasks as &$task)
		{
			$task->params = new \Joomla\Registry\Registry(json_decode($task->params));

			$task = new \Windwalker\Data\Data($task);
		}

		return $this->tasks = new \Windwalker\Data\DataSet($tasks);
	}

	/**
	 * getRelates
	 *
	 * @return  DataSet
	 */
	public function getRelates()
	{
		$entry = $this->getItem();

		$query = $this->db->getQuery(true);

		$query->select('*')
			->from('#__csi_entries')
			->where($query->format('%n LIKE %q', 'title', '%' . $entry->title . '%'))
			->where('id != ' . $entry->id);

		$entries = $this->db->setQuery($query)->loadObjectList();

		array_map(
			function ($entry)
			{
				$entry->params = json_decode($entry->params);

				return new \Windwalker\Data\Data($entry);
			},
			$entries
		);

		return new \Windwalker\Data\DataSet($entries);
	}
}
 