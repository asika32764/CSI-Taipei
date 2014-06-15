<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

use Csi\Table\Table;
use Windwalker\Joomla\DataMapper\DataMapper;
use Windwalker\Model\CrudModel;

/**
 * Class CsiModelEntry
 *
 * @since 1.0
 */
class CsiModelPage extends CrudModel
{
	/**
	 * Property task.
	 *
	 * @var  \Windwalker\Data\Data
	 */
	protected $task = null;

	/**
	 * Property entry.
	 *
	 * @var  \Windwalker\Data\Data
	 */
	protected $entry = null;

	/**
	 * getTask
	 *
	 * @param   integer $pk
	 *
	 * @return  \Windwalker\Data\Data
	 */
	public function getTask($pk = null)
	{
		if ($this->task)
		{
			return $this->task;
		}

		$pk = $pk ? : $this->state->get('task.id');

		$pk = $pk ? : $this->getItem()->task_id;

		return $this->task = with(new DataMapper(Table::TASKS))->findOne($pk);
	}

	/**
	 * getEntry
	 *
	 * @param   integer $pk
	 *
	 * @return  \Windwalker\Data\Data
	 */
	public function getEntry($pk = null)
	{
		if ($this->entry)
		{
			return $this->entry;
		}

		$pk = $pk ? : $this->state->get('entry.id');

		$pk = $pk ? : $this->getItem()->entry_id;

		return $this->entry = with(new DataMapper(Table::ENTRIES))->findOne($pk);
	}
}
 