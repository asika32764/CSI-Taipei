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
class SelfCitedResult extends AbstractResult
{
	/**
	 * Property name.
	 *
	 * @var  string
	 */
	protected $name = 'self_cited';

	/**
	 * get
	 *
	 * @return  mixed
	 */
	public function get()
	{
		$query = $this->db->getQuery(true);

		$query->select('SUM(a.value) AS count')
			->from('#__csi_results AS a')
			->from('#__csi_results AS b')
			->where('a.`task_id` = ' . $this->task->id)
			->where('a.`type` = "page"')
			->where('a.`key` = ' . $query->q($this->name))
			->where('a.fk = b.fk')
			->where('b.key = ' . $query->q('is_syllabus'))
			->where('b.value > 0');

		return $this->db->setQuery($query)->loadResult();
	}
}
 