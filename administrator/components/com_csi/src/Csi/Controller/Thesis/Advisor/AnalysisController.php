<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Csi\Controller\Thesis\Advisor;

use Csi\Database\AbstractDatabase;
use Csi\Database\ThesisDatabase;
use Csi\Engine\AbstractEngine;
use Csi\Engine\AiritiEngine;
use Csi\Engine\EthesysEngine;
use Joomla\Registry\Registry;
use Windwalker\Controller\Controller;
use Windwalker\Data\Data;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * The CsiControllerThesisAdvisorAnalysis class.
 *
 * @since  {DEPLOY_VERSION}
 */
class AnalysisController extends Controller
{
	/**
	 * Property engine.
	 *
	 * @var  AiritiEngine|EthesysEngine
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
	 * @var ThesisDatabase
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
		$engine = AbstractEngine::getInstance($queue->query['engine']);

		$this->engine = $engine;
		$this->queue  = $queue;
		$this->query  = $queue->query;
		$this->task   = (new DataMapper('#__csi_tasks'))->findOne(array('id' => $queue->query['id']));
		$this->database = AbstractDatabase::getInstance('thesis');
	}

	/**
	 * Method to run this controller.
	 *
	 * @return  mixed
	 */
	protected function doExecute()
	{
		$keyword = $this->query->get('keyword');

		$state = $this->engine->getState();

		$state->set('keyword', $keyword);
		$state->set('type', $this->query->get('engine'));

		$result = $this->engine->getPage();

		$result = $this->engine->parsePage($result);

		$this->app->triggerEvent('onThesisAfterAdvisorAnalysis', array($result->advisor, $this->task, $this->query->get('engine')));

		return sprintf('Analysis Ethesys cited success, result: %s.', $result->advisor);
	}
}
