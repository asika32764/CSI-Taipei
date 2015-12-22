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
 * The TaskSeeder class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class TaskSeeder extends AbstractSeeder
{
	/**
	 * doExecute
	 *
	 * @return  void
	 */
	public function doExecute()
	{
		$entries = $this->db->setQuery('SELECT * FROM #__csi_entries')->loadObjectList();

		$databases = [
			'syllabus',
			'paper',
			'social',
			'scholar',
			'thesis',
			'wiki',
			// 'tci',
			'wos',
			'scopus',
			'mendeley'
		];

		foreach ($entries as $entry)
		{
			foreach ($databases as $database)
			{
				$task = new \stdClass;

				$task->title = $entry->title . ' [' . $database . ']';
				$task->entry_id = $entry->id;
				$task->engine = 'google';
				$task->database = $database;
				$task->keyword = '';
				$task->created = (new \JDate)->toSql();
				$task->published = 1;

				$this->db->insertObject('#__csi_tasks', $task, 'id');
			}
		}

		$this->command->out(__CLASS__ . ' executed.');
	}
}
 