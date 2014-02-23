<?php
/**
 * Part of joomla321 project. 
 *
 * @copyright  Copyright (C) 2011 - 2013 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

use Windwalker\Joomla\DataMapper\DataMapper;
use Windwalker\Table\Table;

/**
 * Class CsiTableEntry
 *
 * @since 1.0
 */
class CsiTableEntry extends Table
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('#__csi_entries');
	}

	/**
	 * delete
	 *
	 * @param int $pk
	 *
	 * @return  bool
	 */
	public function delete($pk = null)
	{
		$result = parent::delete($pk);

		if (!$result)
		{
			return $result;
		}

		$mapper = new DataMapper('#__csi_tasks', 'id', $this->_db);

		$result = $mapper->delete(array('entry_id' => $pk));

		return true;
	}
}
