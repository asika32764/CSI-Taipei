<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Date;

/**
 * Class Date
 *
 * @since 1.0
 */
class Date extends \JDate
{
	/**
	 * Constructor.
	 *
	 * @param   string  $date  String in a format accepted by strtotime(), defaults to "now".
	 * @param   mixed   $tz    Time zone to be used for the date. Might be a string or a DateTimeZone object.
	 *
	 * @since   1.0
	 */
	public function __construct($date = 'now', $tz = null)
	{
		$tz = $tz ? : \JFactory::getConfig()->get('offset');

		parent::__construct($date, $tz);
	}
}
 