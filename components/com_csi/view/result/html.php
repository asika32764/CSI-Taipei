<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

use Windwalker\Joomla\DataMapper\DataMapper;
use Windwalker\View\Html\HtmlView;

/**
 * Class CsiViewResult
 *
 * @since 1.0
 */
class CsiViewResultHtml extends HtmlView
{
	/**
	 * prepareData
	 *
	 * @return  void
	 */
	protected function prepareData()
	{
		$input = $this->container->get('input');
		$data  = $this->getData();

		// Prepare query
		$q = $input->getString('q');

		$data->state = $this->get('State');
		$data->query = new \Joomla\Registry\Registry(json_decode($q));
		$data->entry = new \Windwalker\Data\Data($this->get('Item'));

		$data->state->set('databases', $data->query['database']);
		$data->results = $this->get('Result');
	}
}
 