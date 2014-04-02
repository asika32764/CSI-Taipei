<?php
/**
 * Part of Component Csi files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\Controller\Resolver\ControllerDelegator;

// No direct access
defined('_JEXEC') or die;

/**
 * Class CsiControllerWebpagesDelegator
 *
 * @since 1.0
 */
class CsiControllerWebpageDelegator extends ControllerDelegator
{
	/**
	 * registerAliases
	 *
	 * @return  void
	 */
	protected function registerAliases()
	{
	}

	/**
	 * createController
	 *
	 * @param string $class
	 *
	 * @return  \Windwalker\Controller\Controller
	 */
	protected function createController($class)
	{
		$this->config['allow_url_params'] = array(
			'type'
		);

		return parent::createController($class);
	}
}
