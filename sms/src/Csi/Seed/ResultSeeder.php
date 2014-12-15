<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Seed;

use Joomla\Registry\Registry;
use SMS\Seeder\AbstractSeeder;

/**
 * The ResultSeeder class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class ResultSeeder extends AbstractSeeder
{
	/**
	 * doExecute
	 *
	 * @return  void
	 */
	public function doExecute()
	{
		$config = new Registry;
		$config->loadFile(JPATH_ADMINISTRATOR . '/components/com_csi/etc/config.yml', 'yaml');

		$pages = $this->db->setQuery(
			$this->db->getQuery(true)
				->select('*')
				->from('#__csi_pages')
		)->loadObjectList();

		foreach ($pages as $page)
		{
			$task = $this->loadTask($page->task_id);
			$database = $task->database;

			foreach ((array) $config->get('database.' . $database . '.page_result_fields') as $field)
			{
				switch ($database)
				{
					case 'syllabus':
						$type = 'page';
						break;

					default:
						$type = 'engine';
						break;
				}

				$result = new \stdClass;

				$result->entry_id = $task->entry_id;
				$result->task_id  = $task->id;
				$result->fk = $page->id;
				$result->type = $type;
				$result->key = $field;
				$result->value = rand(0, 5);

				$this->db->insertObject('#__csi_results', $result);
			}
		}

		$this->command->out(__CLASS__ . ' executed.');
	}

	/**
	 * loadTask
	 *
	 * @param string $id
	 *
	 * @return  mixed
	 */
	protected function loadTask($id)
	{
		static $tasks = [];

		if (!isset($tasks[$id]))
		{
			$tasks[$id] = $this->db->setQuery(
				$this->db->getQuery(true)
					->select('*')
					->from('#__csi_tasks')
					->where('id = ' . $id)
			)->loadObject();
		}

		return $tasks[$id];
	}
}
