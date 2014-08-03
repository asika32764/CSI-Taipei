<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class CsiViewPageHtml
 *
 * @since 1.0
 */
class CsiViewPageHtml extends \Windwalker\View\Html\ItemHtmlView
{
	/**
	 * prepareRender
	 *
	 * @return  void
	 */
	protected function prepareRender()
	{
		\Csi\User\UserHelper::takeUserToLogin();

		parent::prepareRender();
	}

	/**
	 * prepareData
	 *
	 * @return  void
	 */
	protected function prepareData()
	{
		$this->data->state->set('entry.id', $this->data->item->entry_id);
		$this->data->entry = $this->get('Entry');

		$this->setTitle('頁面詳情: ' . $this->data->item->title);
	}
}
 