<?php

use Windwalker\DI\Container;
use Windwalker\Model\Filter\FilterHelper;
use Windwalker\Model\ListModel;

/**
 * Class CsiModelEnginepages
 *
 * @since 1.0
 */
class CsiModelEnginepages extends ListModel
{
	/**
	 * configureTables
	 *
	 * @return  void
	 */
	protected function configureTables()
	{
		$queryHelper = $this->getContainer()->get('model.enginepages.helper.query', Container::FORCE_NEW);

		$queryHelper->addTable('enginepage', '#__csi_enginepages')
			->addTable('category',  '#__categories', 'enginepage.catid      = category.id')
			->addTable('user',      '#__users',      'enginepage.created_by = user.id')
			->addTable('viewlevel', '#__viewlevels', 'enginepage.access     = viewlevel.id')
			->addTable('lang',      '#__languages',  'enginepage.language   = lang.lang_code');

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
			$table = $this->getTable('Enginepage');

			$ordering = property_exists($table, 'ordering') ? 'enginepage.ordering' : 'enginepage.id';

			$ordering = property_exists($table, 'catid') ? 'enginepage.catid, ' . $ordering : $ordering;
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
		if (!isset($filters['enginepage.published']) && property_exists($this->getTable(), 'published'))
		{
			$query->where($query->quoteName('enginepage.published') . ' >= 0');
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
