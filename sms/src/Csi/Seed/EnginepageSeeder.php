<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Seed;

use SMS\Seeder\AbstractSeeder;

/**
 * The EnginepageSeeder class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class EnginepageSeeder extends AbstractSeeder
{
	/**
	 * doExecute
	 *
	 * @return  void
	 */
	public function doExecute()
	{
		$tasks = $this->db->setQuery(
			$this->db->getQuery(true)
				->select('*')
				->from('#__csi_tasks')
				->where('`database` IN ("syllabus", "paper", "social", "wiki")')
		)->loadObjectList();

		foreach ($tasks as $task)
		{
			$range = rand(1, 10);
			$total = count($range);

			foreach (range(1, $range) as $i)
			{
				$data = new \stdClass;

				$data->entry_id = $task->entry_id;
				$data->task_id  = $task->id;
				$data->engine   = $task->engine;
				$data->state    = 1;
				$data->ordering = $i;
				$data->url      = 'http://www.google.com.tw';
				$data->total    = $total;

				$this->db->insertObject('#__csi_enginepages', $data);
			}
		}

		$this->command->out(__CLASS__ . ' executed.');
	}
}
 