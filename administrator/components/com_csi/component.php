<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_csi
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Csi\Component\CsiComponent as CsiComponentBase;

// No direct access
defined('_JEXEC') or die;

/**
 * Class CsiComponent
 *
 * @since 1.0
 */
final class CsiComponent extends CsiComponentBase
{
	/**
	 * Property defaultController.
	 *
	 * @var string
	 */
	protected $defaultController = 'entries.display';

	/**
	 * init
	 *
	 * @return void
	 */
	protected function prepare()
	{
		parent::prepare();
	}
}
