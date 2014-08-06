<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Webometrics;

use Joomla\Filter\InputFilter;
use PHPHtmlParser\Dom;

/**
 * The GoogleWebometrics class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class YahooWebometrics extends AbstractWebometrics
{
	/**
	 * Count Webometrics
	 *
	 * @param string $html
	 *
	 * @return  mixed
	 */
	protected function countWebometrics($html)
	{
		$html = with(new Dom)->load($html);

		$result = $html->find('div#pg span');

		$filter = new InputFilter;

		if (empty($result[0]))
		{
			return 0;
		}

		return (int) $filter->clean($result[0]->text, 'alnum');
	}
}
 