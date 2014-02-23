<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

use Csi\Helper\EntryHelper;
use Windwalker\Controller\Edit\SaveController;

/**
 * Class CstControllerEntryEditSave
 *
 * @since 1.0
 */
class CsiControllerEntryEditSave extends SaveController
{
	/**
	 * Property databases.
	 *
	 * @var  array
	 */
	protected $databases = array();

	/**
	 * preSaveHook
	 *
	 * @throws  RuntimeException
	 * @return  void
	 */
	protected function preSaveHook()
	{
		if (empty($this->data['database']))
		{
			throw new \RuntimeException('請勾選資料來源');
		}

		$title = EntryHelper::regularizeTitle($this->data['chinese_name'], $this->data['eng_name']);

		// @TODO: If title exists, redirect to it.

		$this->data['title'] = $title;
		$this->data['created'] = (string) new \Windwalker\Date\Date;

		if (!$this->user->get('guest'))
		{
			$this->data['created_by'] = $this->user->get('id');
		}
	}

	/**
	 * Method to check if you can add a new record.
	 *
	 * Extended classes can override this if necessary.
	 *
	 * @param   array  $data  An array of input data.
	 *
	 * @return  boolean
	 *
	 * @since   12.2
	 */
	protected function allowAdd($data = array())
	{
		return true;
	}

	/**
	 * Method to check if you can save a new or existing record.
	 *
	 * Extended classes can override this if necessary.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   12.2
	 */
	protected function allowSave($data, $key = 'id')
	{
		$recordId = isset($data[$key]) ? $data[$key] : '0';

		if ($recordId)
		{
			return $this->allowEdit($data, $key);
		}
		else
		{
			return $this->allowAdd($data);
		}
	}

	/**
	 * Method to check if you can add a new record.
	 *
	 * Extended classes can override this if necessary.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key; default is id.
	 *
	 * @return  boolean
	 *
	 * @since   12.2
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		return $this->user->authorise('core.edit', $this->option);
	}

	/**
	 * allowEditState
	 *
	 * @param array  $data
	 * @param string $key
	 *
	 * @return bool
	 */
	protected function allowUpdateState($data = array(), $key = 'id')
	{
		return $this->user->authorise('core.edit.state', $this->option);
	}
}
 