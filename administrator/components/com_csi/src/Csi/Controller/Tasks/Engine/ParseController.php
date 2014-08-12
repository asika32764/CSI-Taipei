<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Controller\Tasks\Engine;

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
class ParseController extends Controller
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
		$path = $this->enginePage->file;

		if (!is_file($path))
		{
			throw new \RuntimeException(sprintf('File: %s not found', $path));
		}

		$html = file_get_contents($path);

		$pages = $this->engine->parsePage($html);

		$dataSet    = new DataSet($pages);
		$mapper     = new DataMapper('#__csi_pages');
		$queueModel = new QueueModel;

		/** @var $db \JDatabaseDriver */
		$db = $this->container->get('db');

		try
		{
			$db->transactionStart(true);

			foreach ($dataSet as $i => $data)
			{
				$data->task_id  = $this->task->id;
				$data->entry_id = $this->task->entry_id;
				$data->enginepage_id = $this->enginePage->id;
				$data->page     = $this->enginePage->ordering;
				$data->ordering = $i;

				$data = $mapper->createOne($data);

				$query = new \JRegistry(
					array(
						'id' => $data->id
					)
				);

				$this->app->triggerEvent('onBeforeDownloadQueue', array($this->task->database, $this->enginePage, &$data, &$query));

				$queueModel->add('page.download', $query, $this->task, null, 128);
			}
		}
		catch (\Exception $e)
		{
			$db->transactionRollback(true);

			throw $e;
		}

		$db->transactionCommit(true);

		return sprintf('Parse page links success. EnginePage ID: %s', $this->enginePage->id);
	}
}
 