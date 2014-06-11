<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Component;

use Windwalker\DI\Container;

/**
 * Class TaskMapper
 *
 * @since 1.0
 */
class TaskMapper
{
	/**
	 * register
	 *
	 * @param null $resolver
	 *
	 * @return  mixed
	 */
	public static function register($resolver = null)
	{
		$resolver = $resolver ? : Container::getInstance('com_csi')->get('controller.resolver');

		$resolver->registerTask('queue.execute', '\\Csi\\Controller\\Queue\\ExecuteController');

		$resolver->registerTask('tasks.engine.count', '\\Csi\\Controller\\Tasks\\Engine\\CountController');

		$resolver->registerTask('tasks.engine.fetch', '\\Csi\\Controller\\Tasks\\Engine\\FetchController');

		$resolver->registerTask('tasks.engine.parse', '\\Csi\\Controller\\Tasks\\Engine\\ParseController');

		$resolver->registerTask('page.download', '\\Csi\\Controller\\Page\\DownloadController');

		return $resolver;
	}
}
 