<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

use Csi\Registry\RegistryHelper;
use Windwalker\Controller\Edit\SaveController;

/**
 * Class CsiControllerTaskEditSave
 *
 * @since 1.0
 */
class CsiControllerTaskEditSave extends SaveController
{
	/**
	 * Property database.
	 *
	 * @var \stdClass
	 */
	protected $database = null;

	/**
	 * Property entryId.
	 *
	 * @var  int
	 */
	protected $entryId = null;

	/**
	 * preSaveHook
	 *
	 * @throws  RuntimeException
	 * @return  void
	 */
	protected function preSaveHook()
	{
		$this->data = $this->input->getVar('jform');

		$this->database = $currentDatabase = $this->input->getVar('database');

		$this->entryId = $this->input->get('entry_id');

		if (empty($this->data['title']))
		{
			throw new \RuntimeException('無法取得資料來源的標題');
		}

		if (empty($this->database))
		{
			throw new \RuntimeException('無法取得資料來源');
		}

		if (empty($this->entryId))
		{
			throw new \RuntimeException('無法取得搜尋ID');
		}
	}

	/**
	 * doSave
	 *
	 * @throws Exception
	 * @return  array|void
	 */
	protected function doSave()
	{
		$data = new \Windwalker\Data\Data;

		$data->title    = $this->data['title'];
		$data->entry_id = $this->entryId;
		$data->database = $this->database->name;
		$data->engine   = $this->database->engine;
		$data->params   = $this->data['params'];
		$data->created  = $this->data['created'];

		// @TODO: Build keywords.

		$model = $this->getModel();

		try
		{
			$diapatcher = $this->container->get('event.dispatcher');

			// Raise Event
			$args = array(
				$data->database,
				$data->engine,
				$model->getState()->get('task.id'),
				&$data
			);

			// Before save event
			$diapatcher->trigger('onBeforeTaskSave', $args);

			// Do save
			$model->save((array) $data);

			// Push insert id into data
			$data->id = $args[2] = $model->getState()->get('task.id');

			// After save event
			$diapatcher->trigger('onAfterTaskSave', $args);
		}
		catch (\Exception $e)
		{
			// Save the data in the session.
			$this->app->setUserState($this->context . '.data', $data);

			// Redirect back to the edit screen.
			throw new \Exception(\JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $e->getMessage()));
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
 