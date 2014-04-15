<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Database\Syllabus;

use Csi\Database\AbstractResult;

/**
 * Class CitedResult
 *
 * @since 1.0
 */
class SyllabusCountResult extends AbstractResult
{
	/**
	 * Property name.
	 *
	 * @var  string
	 */
	protected $name = 'is_syllabus';

	/**
	 * get
	 *
	 * @return  mixed
	 */
	public function get()
	{
		$query = $this->db->getQuery(true);

		echo $query->select('SUM(`value`) AS count')
			->from('#__csi_results')
			->where('`task_id` = ' . $this->task->id)
			->where('`type` = "page"')
			->where('`key` = ' . $query->q($this->name));

		return $this->db->setQuery($query)->loadResult();
	}
}
 