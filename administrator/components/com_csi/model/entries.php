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
 * Class CsiModelEntries
 *
 * @since 1.0
 */
class CsiModelEntries extends ListModel
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
	protected $viewItem = 'entry';

	/**
	 * Property viewList.
	 *
	 * @var  string
	 */
	protected $viewList = 'entries';

	/**
	 * configureTables
	 *
	 * @return  void
	 */
	protected function configureTables()
	{
		$queryHelper = $this->getContainer()->get('model.entries.helper.query', Container::FORCE_NEW);

		$queryHelper->addTable('entry', '#__csi_entries')
			// ->addTable('category',  '#__categories', 'entry.catid      = category.id')
			->addTable('user',      '#__users',      'entry.created_by = user.id')
			// ->addTable('viewlevel', '#__viewlevels', 'entry.access     = viewlevel.id')
			// ->addTable('lang',      '#__languages',  'entry.language   = lang.lang_code');
		;

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
			$table = $this->getTable('Entry');

			$ordering = property_exists($table, 'ordering') ? 'entry.ordering' : 'entry.id';

			$ordering = property_exists($table, 'catid') ? 'entry.catid, ' . $ordering : $ordering;
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
		if (!isset($filters['entry.state']) && property_exists($this->getTable(), 'state'))
		{
			$query->where($query->quoteName('entry.state') . ' >= 0');
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
