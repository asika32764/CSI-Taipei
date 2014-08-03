<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class CsiViewPagesHtml
 *
 * @since 1.0
 */
class CsiViewPagesHtml extends \Windwalker\View\Html\GridView
{
	/**
	 * prepareRender
	 *
	 * @return  void
	 */
	protected function prepareRender()
	{
		\Csi\User\UserHelper::takeUserToLogin();

		$data             = $this->getData();
		$data->items      = $this->get('Items');
		$data->task       = $this->get('Task');
		$data->pagination = $this->get('Pagination');
		$data->state      = $this->get('State');
		$data->grid       = $this->getGridHelper($this->gridConfig);
		$data->filterForm = $this->get('FilterForm');

		if ($errors = $data->state->get('errors'))
		{
			$this->flash($errors);
		}

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();

			$this->setTitle();
		}

		$lang = JFactory::getLanguage();

		$lang->load('', JPATH_ADMINISTRATOR);
	}

	/**
	 * prepareData
	 *
	 * @return  void
	 */
	protected function prepareData()
	{
		$dispatcher = $this->container->get('event.dispatcher');
		$data = $this->getData();

		$model = new \Csi\Model\ResultModel;

		$state = $model->getState();

		$state->set('page.ids', \JArrayHelper::getColumn($data->items, 'id'));
		$state->set('task.database', $data->task->database);

		$data->results = $model->getPageResults();
		$data->resultFields = $model->getResultFields();

		foreach ($data->items as $i => $item)
		{
			$resultSet = \JArrayHelper::getValue($data->results, $item->id, new \Windwalker\Data\Data);

			$item->results = new \Windwalker\Data\Data;

			if (!$resultSet->isNull())
			{
				foreach ($resultSet as $result)
				{
					$dispatcher->trigger('onPreparePageResult', array($data->task->database, $result->key, $item, $result, $i));
				}
			}
		}
	}

	/**
	 * addSubmenu
	 *
	 * @return  void
	 */
	protected function addSubmenu()
	{
	}
}
 