<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Result;

use Joomla\String\Normalise;

/**
 * The ResultHelper class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class ResultHelper
{
	/**
	 * getHandler
	 *
	 * @param string $field
	 *
	 * @return  string|ResultButtonInterface
	 */
	public static function getHandler($field)
	{
		$field = Normalise::toCamelCase($field);

		return __NAMESPACE__ . '\\' . $field . 'ResultButton';
	}
}
 