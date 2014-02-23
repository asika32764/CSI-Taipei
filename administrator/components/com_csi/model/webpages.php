<?php

use Windwalker\DI\Container;
use Windwalker\Model\Filter\FilterHelper;
use Windwalker\Model\ListModel;

/**
 * Class CsiModelWebpages
 *
 * @since 1.0
 */
class CsiModelWebpages extends ListModel
{
	/**
	 * configureTables
	 *
	 * @return  void
	 */
	protected function configureTables()
	{
		$queryHelper = $this->getContainer()->get('model.webpages.helper.query', Container::FORCE_NEW);

		$queryHelper->addTable('webpage', '#__csi_webpages')
			->addTable('category',  '#__categories', 'webpage.catid      = category.id')
			->addTable('user',      '#__users',      'webpage.created_by = user.id')
			->addTable('viewlevel', '#__viewlevels', 'webpage.access     = viewlevel.id')
			->addTable('lang',      '#__languages',  'webpage.language   = lang.lang_code');

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
			$table = $this->getTable('Webpage');

			$ordering = property_exists($table, 'ordering') ? 'webpage.ordering' : 'webpage.id';

			$ordering = property_exists($table, 'catid') ? 'webpage.catid, ' . $ordering : $ordering;
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
		if (!isset($filters['webpage.published']) && property_exists($this->getTable(), 'published'))
		{
			$query->where($query->quoteName('webpage.published') . ' >= 0');
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
