<?php
/**
 * Part of Component Csi files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\DI\Container;
use Windwalker\Model\Model;
use Windwalker\View\Engine\PhpEngine;
use Windwalker\View\Html\GridView;
use Windwalker\Xul\XulEngine;

// No direct access
defined('_JEXEC') or die;

/**
 * Class PagesHtmlView
 *
 * @since 1.0
 */
class CsiViewPagesHtml extends GridView
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
	 * Method to instantiate the view.
	 *
	 * @param Model            $model     The model object.
	 * @param Container        $container DI Container.
	 * @param array            $config    View config.
	 * @param SplPriorityQueue $paths     Paths queue.
	 */
	public function __construct(Model $model = null, Container $container = null, $config = array(), \SplPriorityQueue $paths = null)
	{
		$config['grid'] = array(
			// Some basic setting
			'option'    => 'com_csi',
			'view_name' => 'page',
			'view_item' => 'page',
			'view_list' => 'pages',

			// Column which we allow to drag sort
			'order_column'   => 'page.catid, page.ordering',

			// Table id
			'order_table_id' => 'pageList',

			// Ignore user access, allow all.
			'ignore_access'  => false
		);

		// Directly use php engine
		$this->engine = new PhpEngine;

		parent::__construct($model, $container, $config, $paths);
	}

	/**
	 * render
	 *
	 * @return void
	 */
	protected function prepareData()
	{
	}

	/**
	 * configToolbar
	 *
	 * @param array $buttonSet
	 * @param null  $canDo
	 *
	 * @return  array
	 */
	protected function configureToolbar($buttonSet = array(), $canDo = null)
	{
		// Get default button set.
		$buttonSet = parent::configureToolbar($buttonSet, $canDo);

		// In debug mode, we remove trash button but use delete button instead.
		if (JDEBUG)
		{
			$buttonSet['trash']['access']  = false;
			$buttonSet['delete']['access'] = true;
		}

		return $buttonSet;
	}
}
