<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Controller\Page;

use Csi\Helper\PageHelper;
use Csi\Model\PageModel;
use Csi\Model\QueueModel;
use Windwalker\Controller\Controller;
use Windwalker\Helper\DateHelper;
use Windwalker\Html\HtmlElement;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * Class DownloadController
 *
 * @since 1.0
 */
class DownloadController extends Controller
{
	/**
	 * Property queue.
	 *
	 * @var \Windwalker\Data\Data
	 */
	protected $queue;

	/**
	 * Property query.
	 *
	 * @var \JRegistry
	 */
	protected $query;

	/**
	 * Property page.
	 *
	 * @var \Windwalker\Data\Data
	 */
	protected $page;

	/**
	 * Property pageMapper.
	 *
	 * @var \Windwalker\Joomla\DataMapper\DataMapper
	 */
	protected $pageMapper;

	/**
	 * prepareExecute
	 *
	 * @return  void
	 */
	protected function prepareExecute()
	{
		$id = $this->input->get('id');

		$this->queue = with(new DataMapper('#__csi_queues'))->findOne(array('id' => $id));

		$this->query = new \JRegistry(json_decode($this->queue->query));

		$this->pageMapper = new DataMapper('#__csi_pages');

		$this->page = $this->pageMapper->findOne(array('id' => $this->query->get('id')));
	}

	/**
	 * doExecute
	 *
	 * @throws \Exception
	 * @return mixed
	 */
	protected function doExecute()
	{
		$pageModel = new PageModel;

		$pageModel->download($this->page);

		$this->page->filepath   = PageHelper::getFilePath($this->page->id, $this->page->filetype);
		$this->page->downloaded = (string) DateHelper::getDate();

		/** @var $db \JDatabaseDriver */
		$db = $this->container->get('db');

		try
		{
			$db->transactionStart(true);

			// Update page
			$this->pageMapper->updateOne($this->page);

			// Analysis
			$task = with(new DataMapper('#__csi_tasks'))->findOne(array('id' => $this->page->task_id));

			$this->container->get('event.dispatcher')
				->trigger('onPageAnalysis', array($task->database, $this->page, $task));
		}
		catch (\Exception $e)
		{
			$db->transactionRollback(true);

			throw $e;
		}

		$db->transactionCommit(true);

		return sprintf('Download page to: %s success.', new HtmlElement('code', $this->page->filepath));
	}
}
 