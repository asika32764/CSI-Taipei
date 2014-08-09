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
	const MODAL = 'modal';
	const NORMAL = 'normal';

	/**
	 * getShortedLink
	 *
	 * @param string $url
	 * @param string $title
	 * @param string $type
	 * @param int    $limit
	 *
	 * @return  string
	 */
	public static function getShortedLink($url, $title = null, $type = 'normal', $limit = 30)
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
			'title' => htmlentities($url)
		);

		if ($type == static::MODAL)
		{
			\JHtmlBehavior::modal();

			$attrs['class'] .= ' modal';
		}

		\JHtmlBootstrap::tooltip();

		return \JHtml::link(htmlentities($url), $title . $dot, $attrs);
	}
}
 