<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Controller\Tasks\Scholar;

use Csi\Database\AbstractDatabase;
use Csi\Database\ScholarDatabase;
use Csi\Engine\AbstractEngine;
use Csi\Model\QueueModel;
use Windwalker\Controller\Controller;
use Windwalker\Data\DataSet;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * Class ParseController
 *
 * @since 1.0
 */
class CountController extends Controller
{
	/**
	 * Property enginePage.
	 *
	 * @var \Windwalker\Data\Data
	 */
	protected $enginePage;

	/**
	 * Property engine.
	 *
	 * @var AbstractEngine
	 */
	protected $engine;

	/**
	 * Property task.
	 *
	 * @var \Windwalker\Data\Data
	 */
	protected $task;

	/**
	 * Property database.
	 *
	 * @var ScholarDatabase
	 */
	protected $database;

	/**
	 * prepareExecute
	 *
	 * @throws \RuntimeException
	 * @return  void
	 */
	protected function prepareExecute()
	{
		$id = $this->input->get('id');

		$queue = with(new DataMapper('#__csi_queues'))->findOne(array('id' => $id));

		if (!(array) $queue)
		{
			throw new \RuntimeException('Queue: ' . $id . ' Not exists');
		}

		$queue->query = new \JRegistry($queue->query);

		$enginePage = with(new DataMapper('#__csi_enginepages'))->findOne(array('id' => $queue->query->get('id')));

		// Prepare engine model to get pages
		$engine = AbstractEngine::getInstance($enginePage->engine);

		$this->engine = $engine;
		$this->enginePage = $enginePage;

		$this->task = with(new DataMapper('#__csi_tasks'))->findOne(array('id' => $enginePage->task_id));
	}

	/**
	 * doExecute
	 *
	 * @throws \RuntimeException
	 * @throws \Exception
	 * @return mixed
	 */
	protected function doExecute()
	{
		$this->app->triggerEvent('onPageAnalysis', array('scholar', $this->enginePage, $this->task));

		return sprintf('Analysis scholar: %s success.', count($this->enginePage->id));
	}
}
 