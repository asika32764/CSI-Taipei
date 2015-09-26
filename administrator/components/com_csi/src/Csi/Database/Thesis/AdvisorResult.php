<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Csi\Database\Thesis;

use Csi\Database\AbstractResult;

/**
 * The AdvisorResult class.
 *
 * @since  {DEPLOY_VERSION}
 */
class AdvisorResult extends AbstractResult
{
	/**
	 * Property type.
	 *
	 * @var  string
	 */
	protected $type = 'engine';

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
			->where('(`key` = "airiti_advisor" OR `key` = "ethesys_advisor")');

		return $this->db->setQuery($query)->loadResult();
	}
}
