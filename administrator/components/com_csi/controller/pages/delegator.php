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
 * Class CsiControllerPagesDelegator
 *
 * @since 1.0
 */
class CsiControllerPagesDelegator extends ControllerDelegator
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
		return parent::createController($class);
	}
}
