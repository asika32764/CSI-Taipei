<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

use Csi\Table\Table;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * Class CsiControllerPagesUpdateResult
 *
 * @since 1.0
 */
class CsiControllerPagesUpdateResult extends \Windwalker\Controller\Admin\AbstractAdminController
{
	/**
	 * prepareExecute
	 *
	 * @throws \UnexpectedValueException
	 * @return void
	 */
	protected function prepareExecute()
	{
	}

	/**
	 * doExecute
	 *
	 * @throws RuntimeException
	 * @return mixed
	 */
	protected function doExecute()
	{
		$dispatcher = $this->container->get('event.dispatcher');

		$field = $this->input->get('field');
		$value = $this->input->get('value');
		$cid = $this->input->get('cid', array(), 'array');

		if (empty($cid[0]))
		{
			throw new \RuntimeException('No cid');
		}

		$page = with(new DataMapper(Table::PAGES))->findOne($cid[0]);
		$task = with(new DataMapper(Table::TASKS))->findOne($page->id);

		$dispatcher->trigger('onBeforeResultUpdate', array($task->database, $page, $field, $value));

		$resultMapper = new DataMapper(Table::RESULTS);

		$result = $resultMapper->findOne(
			array(
				'task_id' => $task->id,
				'fk' => $page->id,
				'key' => $field,
			)
		);

		$result->value = $value;

		$resultMapper->updateOne($result, array('id'));

		$dispatcher->trigger('onAfterResultUpdate', array($task->database, $page, $field, $value));
	}
}
 