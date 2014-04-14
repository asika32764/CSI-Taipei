<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Controller\Queue;

use Windwalker\Controller\Controller;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * Class ExecuteController
 *
 * @since 1.0
 */
class ExecuteController extends Controller
{
	/**
	 * Property queue.
	 *
	 * @var  \Windwalker\Data\Data
	 */
	protected $queue = null;

	/**
	 * Property queueMapper.
	 *
	 * @var  DataMapper
	 */
	protected $queueMapper = null;

	/**
	 * Property pk.
	 *
	 * @var  int
	 */
	protected $pk = null;

	/**
	 * prepareExecute
	 *
	 * @throws \RuntimeException
	 * @return  void
	 */
	protected function prepareExecute()
	{
		$this->pk = $this->input->get('id');

		$this->queueMapper = $mapper = new DataMapper('#__csi_queues');

		if (!$this->pk)
		{
			$this->queue = $mapper->findOne(array('state' => 1), 'priority DESC, id');
		}
		else
		{
			$this->queue = $mapper->findOne(array('id' => $this->pk));

			$this->pk = $this->queue->id;
		}

		if (!(array) $this->queue)
		{
			throw new \RuntimeException('No queue found.');
		}
	}

	/**
	 * doExecute
	 *
	 * @throws \Exception
	 * @return mixed
	 */
	protected function doExecute()
	{
		/** @var $db \JDatabaseDriver */
		$db = $this->container->get('db');

		try
		{
			$db->transactionStart(true);

			// Set processing
			$this->queue->state = 2;

			$this->queueMapper->updateOne($this->queue);

			// Do task
			$result = $this->fetch('Csi', $this->queue->task, array('id' => $this->queue->id));

			// Set finished
			$this->queue->state = 3;

			$this->queueMapper->updateOne($this->queue);
		}
		catch (\Exception $e)
		{
			$db->transactionRollback(true);

			throw $e;
		}

		$db->transactionCommit(true);

		exit($result);
	}
}
 