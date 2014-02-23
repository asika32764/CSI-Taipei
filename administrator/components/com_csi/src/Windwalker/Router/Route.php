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

		$Itemid = static::findItem($data, $option);

		if ($Itemid)
		{
			$data['Itemid'] = $Itemid;
		}

		$url->setQuery($data);

		$url->setPath('index.php');

		return \JRoute::_((string) $url, $xhtml, $ssl);
	}

	/**
	 * Method to find the item in the menu structure
	 *
	 * @param   array  $needles Array of lookup values
	 * @param   string $extension
	 *
	 * @return  mixed
	 * @since   3.1
	 */
	protected static function findItem($needles = array(), $extension = null)
	{
		$app      = \JFactory::getApplication();
		$menus    = $app->getMenu('site');
		$language = isset($needles['language']) ? $needles['language'] : '*';

		// $this->extension may not be set if coming from a static method, check it
		if (is_null($extension))
		{
			$extension = $app->input->getCmd('option');
		}

		// Prepare the reverse lookup array.
		if (!isset(static::$lookup[$language]))
		{
			static::$lookup[$language] = array();

			$component = JComponentHelper::getComponent($extension);

			$attributes = array('component_id');
			$values     = array($component->id);

			if ($language != '*')
			{
				$attributes[] = 'language';
				$values[]     = array($needles['language'], '*');
			}

			$items = $menus->getItems($attributes, $values);

			foreach ($items as $item)
			{
				if (isset($item->query) && isset($item->query['view']))
				{
					$view = $item->query['view'];

					if (!isset(static::$lookup[$language][$view]))
					{
						static::$lookup[$language][$view] = array();
					}

					if (isset($item->query['id']))
					{
						if (is_array($item->query['id']))
						{
							$item->query['id'] = $item->query['id'][0];
						}

						/*
						 * Here it will become a bit tricky
						 * $language != * can override existing entries
						 * $language == * cannot override existing entries
						 */
						if (!isset(static::$lookup[$language][$view][$item->query['id']]) || $item->language != '*')
						{
							static::$lookup[$language][$view][$item->query['id']] = $item->id;
						}
					}
				}
			}
		}

		if ($needles)
		{
			foreach ($needles as $view => $ids)
			{
				if (isset(static::$lookup[$language][$view]))
				{
					foreach ($ids as $id)
					{
						if (isset(static::$lookup[$language][$view][(int) $id]))
						{
							return static::$lookup[$language][$view][(int) $id];
						}
					}
				}
			}
		}

		$active = $menus->getActive();

		if ($active && $active->component == $extension && ($active->language == '*' || !\JLanguageMultilang::isEnabled()))
		{
			return $active->id;
		}

		// If not found, return language specific home link
		$default = $menus->getDefault($language);

		return !empty($default->id) ? $default->id : null;
	}
}
 