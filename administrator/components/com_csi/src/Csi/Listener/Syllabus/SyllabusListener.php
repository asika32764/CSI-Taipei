<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Listener\Syllabus;

use Csi\Database\AbstractDatabase;
use Csi\Listener\DatabaseListener;
use Windwalker\Data\Data;

/**
 * Class SyllabusListener
 *
 * @since 1.0
 */
class SyllabusListener extends DatabaseListener
{
	/**
	 * Property type.
	 *
	 * @var  string
	 */
	protected $type = 'syllabus';

	/**
	 * onBeforeTaskSave
	 *
	 * @param string                $database
	 * @param string                $engine
	 * @param int                   $id
	 * @param \Windwalker\Data\Data $data
	 *
	 * @return  void
	 */
	public function onBeforeTaskSave($database, $engine, $id, Data $data)
	{
		if ($this->checkType($database))
		{
			return;
		}

		$task = AbstractDatabase::getInstance($this->type);

		$data->keyword = $task->getKeyword($data);
	}
}
 