<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

use Windwalker\Model\CrudModel;

/**
 * Class CsiModelEntry
 *
 * @since 1.0
 */
class CsiModelEntry extends CrudModel
{
	/**
	 * getResult
	 *
	 * @return  array
	 */
	public function getResult()
	{
		$dispatcher = $this->container->get('event.dispatcher');
		$databases  = $this->state->get('databases');
		$entry = new \Windwalker\Data\Data($this->getItem());

		// Get Database results
		$results = array();

		foreach ($databases as $database)
		{
			$result = new \Windwalker\Data\Data;

			$dispatcher->trigger('onDatabaseGetResult', array($database, $entry, $result));

			$results[$database] = $result;
		}

		return $results;
	}
}
 