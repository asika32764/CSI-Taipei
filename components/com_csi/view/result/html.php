<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

use Joomla\Registry\Registry;
use Windwalker\Data\Data;
use Windwalker\Helper\ArrayHelper;
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
		$data->state->set('entry.id', $data->entry->id);

		$data->results = $this->get('Result');
		$data->tasks = $this->get('Tasks');
		$data->relates = $this->get('Relates');

		$this->prepareQueries($data->entry, $data->query);

		foreach ($data->relates as $relate)
		{
			$query = clone $data->query;

			$this->overrideQueries($relate, $query);

			$queries['id'] = $relate->id;
			$queries['q'] = $query->toString();

			$relate->link = \Csi\Router\Route::_('result', $queries);
		}
	}

	/**
	 * prepareQueries
	 *
	 * @param Data     $entry
	 * @param Registry $query
	 *
	 * @return  void
	 */
	protected function prepareQueries(Data $entry, Registry $query)
	{
		$query->def('chinese_name', ArrayHelper::getByPath($entry->params, 'name.chinese'));
		$query->def('eng_name',     ArrayHelper::getByPath($entry->params, 'name.eng'));
		$query->def('school',       ArrayHelper::getByPath($entry->params, 'school'));
	}

	/**
	 * overrideQueries
	 *
	 * @param Data     $entry
	 * @param Registry $query
	 *
	 * @return  void
	 */
	protected function overrideQueries(Data $entry, Registry $query)
	{
		$query->set('chinese_name', ArrayHelper::getByPath($entry->params, 'name.chinese'));
		$query->set('eng_name',     ArrayHelper::getByPath($entry->params, 'name.eng'));
		$query->set('school',       ArrayHelper::getByPath($entry->params, 'school'));
	}
}
 