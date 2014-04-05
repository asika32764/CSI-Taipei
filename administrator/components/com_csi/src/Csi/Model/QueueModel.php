<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Model;

use Windwalker\Data\Data;
use Windwalker\Helper\DateHelper;
use Windwalker\Model\AdminModel;

/**
 * Class QueueModel
 *
 * @since 1.0
 */
class QueueModel extends AdminModel
{
	/**
	 * Property prefix.
	 *
	 * @var  string
	 */
	protected $prefix = 'csi';

	/**
	 * Property component.
	 *
	 * @var string
	 */
	protected $component = 'csi';

	/**
	 * Property option.
	 *
	 * @var  string
	 */
	protected $option = 'com_csi';

	/**
	 * Property textPrefix.
	 *
	 * @var string
	 */
	protected $textPrefix = 'COM_CSI';

	/**
	 * Property viewItem.
	 *
	 * @var  string
	 */
	protected $viewItem = 'queue';

	/**
	 * Property viewList.
	 *
	 * @var  string
	 */
	protected $viewList = 'queues';

	/**
	 * Property name.
	 *
	 * @var  string
	 */
	protected $name = 'queue';

	/**
	 * add
	 *
	 * @param string     $task
	 * @param \JRegistry $query
	 * @param \JRegistry $params
	 * @param int        $priority
	 *
	 * @return  boolean
	 */
	public function add($task, \JRegistry $query = null, \JRegistry $params = null, $priority = 256)
	{
		$query  = $query  ? : new \JRegistry;
		$params = $params ? : new \JRegistry;

		$queue = new Data;
		$queue->task     = $task;
		$queue->query    = $query->toString();
		$queue->created  = (string) DateHelper::getDate();
		$queue->params   = $params;
		$queue->priority = $priority;

		return $this->save((array) $queue);
	}

	/**
	 * executing
	 *
	 * @param int $id
	 *
	 * @return  bool
	 */
	public function executing($id)
	{
		return $this->changeState($id, 2);
	}

	/**
	 * executing
	 *
	 * @param int $id
	 *
	 * @return  bool
	 */
	public function finished($id)
	{
		return $this->changeState($id, 3);
	}

	/**
	 * changeState
	 *
	 * @param int $id
	 * @param int $state
	 *
	 * @return  bool
	 */
	public function changeState($id, $state)
	{
		if (!$id)
		{
			return false;
		}

		$queue = array(
			'id'    => $id,
			'state' => $state
		);

		return $this->save($queue);
	}
}
 