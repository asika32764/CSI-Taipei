<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Controller\Mendeley\Cited;

use Csi\Database\AbstractDatabase;
use Csi\Database\MendeleyDatabase;
use Csi\Engine\AbstractEngine;
use Csi\Engine\MendeleyEngine;
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
	 * @var MendeleyEngine
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
	 * @var MendeleyDatabase
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
		$engine = AbstractEngine::getInstance('mendeley');

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
		$keyword = $this->query->get('keyword');

		$this->engine->getState()->set('keyword', $keyword);

		// $result = $this->engine->getPage();

		$result = file_get_contents(CSI_ADMIN . '/test/mendeley/mendeley.json');

		$result = $this->engine->parsePage($result);

		$this->app->triggerEvent('onMendeleyAfterAnalysis', array($result->cited, $this->task));

		return sprintf('Analysis Mendeley author success, result: %s.', $result->cited);
	}
}
