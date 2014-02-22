<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

use Windwalker\Controller\Resolver\ControllerDelegator;

/**
 * Class CsiControllerPagesDelegator
 *
 * @since 1.0
 */
class CsiControllerPagesDelegator extends ControllerDelegator
{
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
