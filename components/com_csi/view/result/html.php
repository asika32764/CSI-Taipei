<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

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

		$q = $input->getString('q');

		$q = json_decode($q);

		$data = $this->getData();

		$data->query = new \Joomla\Registry\Registry($q);
	}
}
 