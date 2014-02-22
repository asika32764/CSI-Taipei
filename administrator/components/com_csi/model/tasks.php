<?php

use Windwalker\DI\Container;
use Windwalker\Model\Filter\FilterHelper;
use Windwalker\Model\ListModel;

/**
 * Class CsiModelTasks
 *
 * @since 1.0
 */
class CsiModelTasks extends ListModel
{
	/**
	 * configureTables
	 *
	 * @return  void
	 */
	protected function configureTables()
	{
		$queryHelper = $this->getContainer()->get('model.tasks.helper.query', Container::FORCE_NEW);

		$queryHelper->addTable('task', '#__csi_tasks')
			->addTable('category',  '#__categories', 'task.catid      = category.id')
			->addTable('user',      '#__users',      'task.created_by = user.id')
			->addTable('viewlevel', '#__viewlevels', 'task.access     = viewlevel.id')
			->addTable('lang',      '#__languages',  'task.language   = lang.lang_code');

		$this->filterFields = array_merge($this->filterFields, $queryHelper->getFilterFields());
	}

	/**
	 * populateState
	 *
	 * @param null $ordering
	 * @param null $direction
	 *
	 * @return  void
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Build ordering prefix
		if (!$ordering)
		{
			$table = $this->getTable('Task');

			$ordering = property_exists($table, 'ordering') ? 'task.ordering' : 'task.id';

			$ordering = property_exists($table, 'catid') ? 'task.catid, ' . $ordering : $ordering;
		}

		parent::populateState($ordering, 'ASC');
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
		// If no state filter, set published >= 0
		if (!isset($filters['task.published']) && property_exists($this->getTable(), 'published'))
		{
			$query->where($query->quoteName('task.published') . ' >= 0');
		}

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
