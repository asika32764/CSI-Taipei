<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Database\Wiki;

use Csi\Database\AbstractResult;

/**
 * The CitmentionedResult class.
 * 
 * @since  {DEPLOY_VERSION}
 *
 * @deprecated No longer used.
 */
class CitmentionedResult extends AbstractResult
{
	/**
	 * Property name.
	 *
	 * @var  string
	 */
	protected $name = 'cited_mentioned';

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
			->where('`key` = ' . $query->q('cited'));

		$cited = $this->db->setQuery($query)->loadResult();

		$query->clear()
			->select('SUM(`value`) AS count')
			->from('#__csi_results')
			->where('`task_id` = ' . $this->task->id)
			->where('`type` = "page"')
			->where('`key` = ' . $query->q('mentioned'));

		$mentioned = $this->db->setQuery($query)->loadResult();

		return $cited + $mentioned;
	}
}
 