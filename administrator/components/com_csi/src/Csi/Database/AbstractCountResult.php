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
			->where('`type` = "page"')
			->where('`key` = ' . $query->q($this->name));

		return $this->db->setQuery($query)->loadResult();
	}
}
 