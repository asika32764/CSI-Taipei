<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Component;

/**
 * Class TaskMapper
 *
 * @since 1.0
 */
class TaskMapper
{
	/**
	 * Property component.
	 *
	 * @var  \Csi\Component\CsiComponent
	 */
	protected $component = null;

	/**
	 * Class init.
	 *
	 * @param $component
	 */
	public function __construct($component)
	{
		$this->component = $component;
	}

	/**
	 * register
	 *
	 * @return  void
	 */
	public function register()
	{
		$this->component->registerTask('tasks.engine.count', '\\Csi\\Controller\\Tasks\\Engine\\CountController');

		$this->component->registerTask('tasks.engine.fetch', '\\Csi\\Controller\\Tasks\\Engine\\FetchController');

		$this->component->registerTask('tasks.engine.parse', '\\Csi\\Controller\\Tasks\\Engine\\ParseController');
	}
}
 