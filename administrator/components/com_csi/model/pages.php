<?php

use Windwalker\DI\Container;
use Windwalker\Model\Filter\FilterHelper;
use Windwalker\Model\ListModel;

/**
 * Class CsiModelPages
 *
 * @since 1.0
 */
class CsiModelPages extends ListModel
{
	/**
	 * configureTables
	 *
	 * @return  void
	 */
	protected function configureTables()
	{
		$queryHelper = $this->getContainer()->get('model.pages.helper.query', Container::FORCE_NEW);

		$queryHelper->addTable('page', '#__csi_pages')
			->addTable('category',  '#__categories', 'page.catid      = category.id')
			->addTable('user',      '#__users',      'page.created_by = user.id')
			->addTable('viewlevel', '#__viewlevels', 'page.access     = viewlevel.id')
			->addTable('lang',      '#__languages',  'page.language   = lang.lang_code');

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
			$table = $this->getTable('Page');

			$ordering = property_exists($table, 'ordering') ? 'page.ordering' : 'page.id';

			$ordering = property_exists($table, 'catid') ? 'page.catid, ' . $ordering : $ordering;
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
		if (!isset($filters['page.published']) && property_exists($this->getTable(), 'published'))
		{
			$query->where($query->quoteName('page.published') . ' >= 0');
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
