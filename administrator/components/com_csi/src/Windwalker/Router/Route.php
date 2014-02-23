<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Windwalker\Router;

use JComponentHelper;

/**
 * Class Route
 *
 * @since 1.0
 */
class Route
{
	protected static $lookup;

	/**
	 * Proxy of build()
	 *
	 * @param string  $resource
	 * @param array   $data
	 * @param boolean $xhtml
	 * @param boolean $ssl
	 *
	 * @return  string Route url.
	 */
	public static function _($resource, $data = array(), $xhtml = true, $ssl = null)
	{
		return static::build($resource, $data, $xhtml, $ssl);
	}

	/**
	 * Build route.
	 *
	 * @param string  $resource
	 * @param array   $data
	 * @param boolean $xhtml
	 * @param boolean $ssl
	 *
	 * @return  string Route url.
	 */
	public static function build($resource, $data = array(), $xhtml = true, $ssl = null)
	{
		list($option, $resource) = explode('.', $resource, 2);

		$url = new \JUri;

		$data['option'] = $option;
		$data['view']   = $resource;

		$menu = \JFactory::getApplication()->getMenu();

		$items = $menu->getMenu();

		$Itemid = null;

		// Find option and view
		foreach ($items as $item)
		{
			$option = \JArrayHelper::getValue($item->query, 'option');
			$view   = \JArrayHelper::getValue($item->query, 'view');

			if ($option == $data['option'] && $view == $data['view'])
			{
				unset($data['view']);

				$Itemid = $item->id;

				break;
			}
		}

		// Find option
		if (!$Itemid)
		{
			foreach ($items as $item)
			{
				$option = \JArrayHelper::getValue($item->query, 'option');

				if ($option == $data['option'])
				{
					$Itemid = $item->id;

					break;
				}
			}
		}

		if ($Itemid)
		{
			$data['Itemid'] = $Itemid;
		}

		$url->setQuery($data);

		$url->setPath('index.php');

		return \JRoute::_($url, $xhtml, $ssl);
	}
}
 