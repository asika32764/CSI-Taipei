<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_csi
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Class CsiComponent
 *
 * @since 1.0
 */
final class CsiComponent extends \Csi\Component\CsiComponent
{
	/**
	 * Property defaultController.
	 *
	 * @var string
	 */
	protected $defaultController = 'entry.display';

	/**
	 * init
	 *
	 * @return void
	 */
	protected function prepare()
	{
		parent::prepare();

		$asset = $this->container->get('helper.asset');

		$asset->addCss('main.css');
	}
}