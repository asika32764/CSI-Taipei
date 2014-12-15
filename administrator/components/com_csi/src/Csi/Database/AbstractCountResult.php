<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Database;

/**
 * The AbstractCountResult class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class AbstractCountResult extends AbstractResult
{
	/**
	 * Property type.
	 *
	 * @var  string
	 */
	protected $type = 'page';

	/**
	 * get
	 *
	 * @return  mixed
	 */
	public function get()
	{
		$query = $this->db->getQuery(true);

		$query->select('SUM(`value`) AS count')
			->from('#__csi_results')
			->where('`task_id` = ' . $this->task->id)
			->where('`type` = ' . $query->quote($this->type))
			->where('`key` = ' . $query->q($this->name));

		return $this->db->setQuery($query)->loadResult();
	}
}
 