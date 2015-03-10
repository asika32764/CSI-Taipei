<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Controller\Wos\Cited;

use Csi\Database\AbstractDatabase;
use Csi\Database\WosDatabase;
use Csi\Engine\AbstractEngine;
use Csi\Engine\WosEngine;
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
	 * @var WosEngine
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
	 * @var WosDatabase
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
		$engine = AbstractEngine::getInstance('wos');

		$this->engine = $engine;
		$this->queue  = $queue;
		$this->query  = $queue->query;
		$this->task   = (new DataMapper('#__csi_tasks'))->findOne(array('id' => $queue->query['id']));
		$this->database = AbstractDatabase::getInstance('wos');
	}

	/**
	 * Method to run this controller.
	 *
	 * @return  mixed
	 */
	protected function doExecute()
	{
		$result = $this->engine->getCited($this->query->get('page.doi'));

		$cited = (string) $result->fn->map->map->map->val[1];

		$this->app->triggerEvent('onWosAfterAnalysis', array($cited, $this->task));

		return sprintf('Analysis WOS page success, result: %s.', $cited);
	}
}
