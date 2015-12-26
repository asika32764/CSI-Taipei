<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

/**
 * The CsiControllerQueueExecute class.
 *
 * @since  {DEPLOY_VERSION}
 */
class CsiControllerQueueExecute extends \Windwalker\Controller\Controller
{
	/**
	 * Method to run this controller.
	 *
	 * @return mixed
	 *
	 * @throws Exception
	 */
	protected function doExecute()
	{
		$queueMapper = new \Windwalker\Joomla\DataMapper\DataMapper('#__csi_queues');

		$queue = $queueMapper->findOne(array('state' => 1), 'priority DESC, id');

		if (!(array) $queue)
		{
			throw new \RuntimeException('No queue found.');
		}

		$db = \JFactory::getDbo();

		try
		{
			$db->transactionStart(true);

			// Set processing
			$queue->state = 2;

			$queueMapper->updateOne($queue);

			// Do task
			$result = $this->fetch('Csi', $queue->task, array('id' => $queue->id));

			// Set finished
			$queue->state = 3;

			$queueMapper->updateOne($queue);
		}
		catch (\Exception $e)
		{
			$db->transactionRollback(true);

			// Set closed
			$queue->state = 0;

			$queueMapper->updateOne($queue);

			throw $e;
		}

		$db->transactionCommit(true);

		return $result;
	}
}
