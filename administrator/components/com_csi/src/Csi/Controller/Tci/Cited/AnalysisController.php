<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Controller\Tci\Cited;

use Csi\Database\AbstractDatabase;
use Csi\Database\TciDatabase;
use Csi\Engine\AbstractEngine;
use Joomla\Registry\Registry;
use Windwalker\Controller\Controller;
use Windwalker\Data\Data;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * The AnalysisController class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class AnalysisController extends Controller
{
	/**
	 * Property engine.
	 *
	 * @var AbstractEngine
	 */
	protected $engine;

	/**
	 * Property queue.
	 *
	 * @var Data
	 */
	protected $queue;

	/**
	 * Property query.
	 *
	 * @var \JRegistry
	 */
	protected $query;

	/**
	 * Property database.
	 *
	 * @var TciDatabase
	 */
	protected $database;

	/**
	 * prepareExecute
	 *
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

		$queue->query = new Registry($queue->query);

		// Prepare engine model to get pages
		$engine = AbstractEngine::getInstance('tci');

		$this->engine = $engine;
		$this->queue  = $queue;
		$this->query  = $queue->query;
		$this->task   = (new DataMapper('#__csi_tasks'))->findOne(array('id' => $queue->query['id']));
		$this->database = AbstractDatabase::getInstance('tci');
	}

	/**
	 * Method to run this controller.
	 *
	 * @return  mixed
	 */
	protected function doExecute()
	{
		$state = $this->engine->getState();

		$state->set('keyword', $this->query['keyword']);
		$state->set('type', TciDatabase::TYPE_CITED);

		$page = $this->engine->getPage($this->query['num']);

		$result = $this->database->parseCited($page);

		$this->app->triggerEvent('onTciAfterAnalysis', array($result, $this->task));

		return sprintf('Analysis TCI page: %s success.', count($this->query['num']));
	}
}
