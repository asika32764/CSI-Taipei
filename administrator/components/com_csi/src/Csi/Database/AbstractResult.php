<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Database;

use Windwalker\Data\Data;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * Class AbstractResult
 *
 * @since 1.0
 */
abstract class AbstractResult extends \JModelDatabase
{
	/**
	 * Property name.
	 *
	 * @var  string
	 */
	protected $name = '';

	/**
	 * Property task.
	 *
	 * @var  \Windwalker\Data\Data
	 */
	protected $task = null;

	/**
	 * Property mapper.
	 *
	 * @var  \Windwalker\Joomla\DataMapper\DataMapper
	 */
	protected $mapper = null;

	/**
	 * Class init.
	 *
	 * @param \Windwalker\Data\Data $task
	 */
	function __construct(Data $task)
	{
		$this->task = $task;

		$this->mapper = new DataMapper('#__csi_results');

		parent::__construct();
	}

	/**
	 * get
	 *
	 * @return  mixed
	 */
	abstract public function get();
}
 