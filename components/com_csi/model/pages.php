<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

use Csi\Table\Table;
use Windwalker\DI\Container;
use Windwalker\Joomla\DataMapper\DataMapper;
use Windwalker\Model\Helper\QueryHelper;

/**
 * Class CsiModelEntry
 *
 * @since 1.0
 */
class CsiModelPages extends \Windwalker\Model\ListModel
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
	protected $viewItem = 'page';

	/**
	 * Property viewList.
	 *
	 * @var  string
	 */
	protected $viewList = 'pages';

	/**
	 * configureTables
	 *
	 * @return  void
	 */
	protected function configureTables()
	{
		$queryHelper = $this->getContainer()->get('model.pages.helper.query', Container::FORCE_NEW);

		$queryHelper->addTable('page', '#__csi_pages')
//			->addTable('task',  '#__csi_tasks', 'page.task_id = task.id')
//			->addTable('user',      '#__users',      'page.created_by = user.id')
//			->addTable('viewlevel', '#__viewlevels', 'page.access     = viewlevel.id')
//			->addTable('lang',      '#__languages',  'page.language   = lang.lang_code')
		;

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
	protected function populateState($ordering = 'id', $direction = 'ASC')
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
		// If no state filter, set published >= 0
		if (!isset($filters['page.state']) && property_exists($this->getTable(), 'state'))
		{
			$query->where($query->quoteName('page.state') . ' >= 0');
		}

		return parent::processFilters($query, $filters);
	}

	/**
	 * configureFilters
	 *
	 * @param \Windwalker\Model\Filter\FilterHelper $filterHelper
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

	public function getBatchForm($data = array(), $loadData = false)
	{
		return null;
	}

	/**
	 * getTask
	 *
	 * @return  \Windwalker\Data\Data
	 */
	public function getTask()
	{
		return with(new DataMapper(Table::TASKS))->findOne(\JFactory::getApplication()->input->get('id'));
	}
}
