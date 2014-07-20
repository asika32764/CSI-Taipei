<?php
/**
 * Part of Component Csi files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\DI\Container;
use Windwalker\Model\Filter\FilterHelper;
use Windwalker\Model\ListModel;

// No direct access
defined('_JEXEC') or die;

/**
 * Class CsiModelTasks
 *
 * @since 1.0
 */
class CsiModelTasks extends ListModel
{
	/**
	 * Property prefix.
	 *
	 * @var  string
	 */
	protected $prefix = 'csi';

	/**
	 * Property option.
	 *
	 * @var  string
	 */
	protected $option = 'com_csi';

	/**
	 * Property textPrefix.
	 *
	 * @var string
	 */
	protected $textPrefix = 'COM_CSI';

	/**
	 * Property viewItem.
	 *
	 * @var  string
	 */
	protected $viewItem = 'task';

	/**
	 * Property viewList.
	 *
	 * @var  string
	 */
	protected $viewList = 'tasks';

	/**
	 * configureTables
	 *
	 * @return  void
	 */
	protected function configureTables()
	{
		$queryHelper = $this->getContainer()->get('model.tasks.helper.query', Container::FORCE_NEW);

		$queryHelper->addTable('task', '#__csi_tasks')
			->addTable('entry', '#__csi_entries', 'task.entry_id = entry.id');

		$this->filterFields = array_merge($this->filterFields, $queryHelper->getFilterFields());
	}

	/**
	 * populateState
	 *
	 * @param string $ordering
	 * @param string $direction
	 *
	 * @return  void
	 */
	protected function populateState($ordering = 'task.id', $direction = 'asc')
	{
		parent::populateState($ordering, $direction);
	}

	/**
	 * processFilters
	 *
	 * @param JDatabaseQuery $query
	 * @param array          $filters
	 *
	 * @return  JDatabaseQuery
	 */
	protected function processFilters(\JDatabaseQuery $query, $filters = array())
	{
		return parent::processFilters($query, $filters);
	}

	/**
	 * configureFilters
	 *
	 * @param FilterHelper $filterHelper
	 *
	 * @return  void
	 */
	protected function configureFilters($filterHelper)
	{
	}

	/**
	 * configureSearches
	 *
	 * @param \Windwalker\Model\Filter\SearchHelper $searchHelper
	 *
	 * @return  void
	 */
	protected function configureSearches($searchHelper)
	{
	}
}
