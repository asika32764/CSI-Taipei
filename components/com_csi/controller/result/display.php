<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class CsiControllerDisplay
 *
 * @since 1.0
 */
class CsiControllerResultDisplay extends \Windwalker\Controller\DisplayController
{
	/**
	 * assignModel
	 *
	 * @param \Windwalker\View\Html\AbstractHtmlView $view
	 *
	 * @return  void
	 */
	protected function assignModel($view)
	{
		$view->setModel($this->getModel('Entry'), true);
	}
}
 