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
 * The DatabaseSeeder class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class DatabaseSeeder extends AbstractSeeder
{
	/**
	 * doExecute
	 *
	 * @return  void
	 */
	public function doExecute()
	{
		$this->execute(new EntrySeeder);
		$this->execute(new TaskSeeder);
		$this->execute(new EnginepageSeeder);
		$this->execute(new PageSeeder);
		$this->execute(new ResultSeeder);
	}

	/**
	 * doClean
	 *
	 * @return  void
	 */
	public function doClean()
	{
		$this->db->truncateTable('#__csi_entries');
		$this->db->truncateTable('#__csi_tasks');
		$this->db->truncateTable('#__csi_enginepages');
		$this->db->truncateTable('#__csi_pages');
		$this->db->truncateTable('#__csi_results');
	}
}
 