<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Seed;

use Faker\Factory;
use SMS\Seeder\AbstractSeeder;

/**
 * The PageSeeder class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class PageSeeder extends AbstractSeeder
{
	/**
	 * doExecute
	 *
	 * @return  void
	 */
	public function doExecute()
	{
		$faker = Factory::create();

		$tasks = $this->db->setQuery(
			$this->db->getQuery(true)
				->select('*')
				->from('#__csi_tasks')
		)->loadObjectList();

		foreach ($tasks as $task)
		{
			foreach (range(1, rand(150, 1000)) as $i)
			{
				$data = new \stdClass;

				$data->entry_id = $task->entry_id;
				$data->task_id  = $task->id;
				$data->state    = 1;
				$data->title    = '思想與中國專題研究 - 課程大綱';
				$data->url      = 'https://nol.ntu.edu.tw/nol/coursesearch/print_table.php?course_id=322%20D1440&class=&dpt_code=3220&ser_no=73806&semester=103-1';
				$data->filetype = $faker->randomElement(['html', 'doc', 'pdf', 'ppt']);
				$data->downloaded = 1;
				$data->created    = (new \JDate)->toSql();
				$data->page       = floor($i / 1000) + 1;
				$data->published  = 1;

				$this->db->insertObject('#__csi_pages', $data);
			}
		}

		$this->command->out(__CLASS__ . ' executed.');
	}
}
