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
		$data             = $this->getData();
		$data->items      = $this->get('Items');
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
	 * addSubmenu
	 *
	 * @return  void
	 */
	protected function addSubmenu()
	{
	}
}
 