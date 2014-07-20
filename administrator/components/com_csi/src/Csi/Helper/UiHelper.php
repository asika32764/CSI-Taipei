<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Helper;

/**
 * Class UiHelper
 *
 * @since 1.0
 */
class UiHelper
{
	/**
	 * getShortedLink
	 *
	 * @param string $url
	 * @param string $title
	 * @param int    $limit
	 *
	 * @return  string
	 */
	public static function getShortedLink($url, $title = null, $limit = 30)
	{
		$dot = '';

		if (strlen($url) > $limit && !$title)
		{
			$dot = '...';
		}

		$title = $title ? : substr($url, 0, $limit);

		$attrs = array(
			'target' => '_blank',
			'class' => 'hasTooltip',
			'title' => $url
		);

		\JHtmlBootstrap::tooltip();

		return \JHtml::link($url, $title . $dot, $attrs);
	}
}
 