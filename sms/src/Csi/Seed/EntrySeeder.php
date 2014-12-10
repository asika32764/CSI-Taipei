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
 * The EntrySeeder class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class EntrySeeder extends AbstractSeeder
{
	/**
	 * doExecute
	 *
	 * @return  void
	 */
	public function doExecute()
	{
		$entries = json_decode(file_get_contents(__DIR__ . '/fixtures.json'));

		foreach ($entries as $entry)
		{
			$data = new \stdClass;

			$data->title = $entry->title;
			$data->created = (new \JDate)->toSql();
			$data->published = 1;
			unset($entry->title);
			$data->params = json_encode($entry);

			$this->db->insertObject('#__csi_entries', $data, 'id');
		}

		$this->command->out(__CLASS__ . ' executed.');
	}
}
 