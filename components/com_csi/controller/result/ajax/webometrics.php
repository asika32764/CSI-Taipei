<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */
use Csi\Model\WebpageModel;
use Csi\Table\Table;
use Windwalker\Data\Data;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * The CsiControllerResultAjaxWebometrics class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class CsiControllerResultAjaxWebometrics extends \Windwalker\Controller\Controller
{
	/**
	 * Property url.
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * prepareExecute
	 *
	 * @return  void
	 */
	protected function prepareExecute()
	{
		$this->url = $this->input->getString('url');

		$this->url = new JUri($this->url);

		if (!$this->url->getScheme())
		{
			$this->url->setScheme('http');
		}

		$this->url = $this->url->toString();
	}

	/**
	 * Method to run this controller.
	 *
	 * @return  mixed
	 */
	protected function doExecute()
	{
		$mapper = new DataMapper(Table::WEB_PAGES);

		$webpage = $mapper->findOne(array('url' => trim($this->url, '/')));

		$nowDate = \Windwalker\Helper\DateHelper::getDate();
		$lastDate = new JDate($webpage->modified);

		$interval = $nowDate->diff($lastDate);

		if (!$webpage->isNull() && $interval->format('%a') < 30)
		{
			return $webpage;
		}

		$data = array('url' => $this->url);

		if ($webpage->id)
		{
			$data['id'] = $webpage->id;
		}

		$model = new WebpageModel;

		try
		{
			$model->save($data);
		}
		catch (\Exception $e)
		{
			$result = array(
				'success' => false,
				'message' => $e->getMessage(),
				'code' => $e->getCode()
			);

			if (JDEBUG)
			{
				$result['backtrace'] = $e->getTrace();
			}

			exit(json_encode($result));
		}

		return $mapper->findOne(array('url' => trim($this->url, '/')));
	}

	/**
	 * postExecute
	 *
	 * @param array|Data $data
	 *
	 * @return  mixed|void
	 */
	protected function postExecute($data = null)
	{
		header('Content-Type: application/json; charset=utf-8;');

		$data->params = json_decode($data->params);

		$result = array(
			'success' => true,
			'data' => $data
		);

		exit(json_encode($result));
	}
}
 