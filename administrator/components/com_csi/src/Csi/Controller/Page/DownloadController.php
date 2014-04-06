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
use Windwalker\Controller\Controller;
use Windwalker\Helper\DateHelper;
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

		show($this->page);
	}

	/**
	 * doExecute
	 *
	 * @return mixed
	 */
	protected function doExecute()
	{
		$pageModel = new PageModel;

		$pageModel->download($this->page->id, urldecode($this->page->url));

		$this->page->filepath   = PageHelper::getFilePath($this->page->id, $this->page->filetype);
		$this->page->downloaded = (string) DateHelper::getDate();

		$this->pageMapper->updateOne($this->page);

		die;
	}
}
 