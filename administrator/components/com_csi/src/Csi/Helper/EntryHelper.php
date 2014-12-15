<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Helper;

use Csi\Router\Route;
use Joomla\String\Normalise;
use Joomla\String\String;
use Windwalker\Html\HtmlElement;
use Windwalker\Joomla\DataMapper\DataMapper;

/**
 * Class EntryHelper
 *
 * @since 1.0
 */
class EntryHelper
{
	/**
	 * regularizeTitle
	 *
	 * @param $chineseName
	 * @param $engNames
	 *
	 * @return  string
	 */
	public static function regularizeTitle($chineseName, $engNames)
	{
		$chineseName = trim($chineseName);

		$names = array();

		foreach ($engNames as $engName)
		{
			$first = \JArrayHelper::getValue($engName, 'first');
			$last  = \JArrayHelper::getValue($engName, 'last');

			$first = static::regularizeEngName($first);
			$last  = static::regularizeEngName($last);

			$name = trim($first . ' ' . $last);

			if ($name && !in_array($name, $names))
			{
				$names[] = $name;
			}
		}

		sort($names);

		array_unshift($names, $chineseName);

		return trim(implode(';', $names), ' ;');
	}

	/**
	 * regularizeEngName
	 *
	 * @param $name
	 *
	 * @return  string
	 */
	public static function regularizeEngName($name)
	{
		// Trim
		$name = trim($name);

		// Capital
		$name = Normalise::toSpaceSeparated($name);

		$name = String::ucwords($name);

		$name = Normalise::toDashSeparated($name);

		return $name;
	}

	/**
	 * Make english name distinct.
	 *
	 * @param array $engNames
	 *
	 * @return  array
	 */
	public static function distinctEngName($engNames)
	{
		$names = array();

		foreach ($engNames as $engName)
		{
			$first = \JArrayHelper::getValue($engName, 'first');
			$last  = \JArrayHelper::getValue($engName, 'last');

			$first = static::regularizeEngName($first);
			$last  = static::regularizeEngName($last);

			if ($first && !in_array($first, $names))
			{
				$names[] = $first;
			}

			if ($last && !in_array($last, $names))
			{
				$names[] = $last;
			}
		}

		sort($names);

		return $names;
	}

	/**
	 * cleanEngNames
	 *
	 * @param array $engNames
	 *
	 * @return  array
	 */
	public static function cleanEngNames($engNames)
	{
		$names = array();

		foreach ($engNames as $engName)
		{
			$first = \JArrayHelper::getValue($engName, 'first');
			$last  = \JArrayHelper::getValue($engName, 'last');

			if (!trim($first) && !trim($last))
			{
				continue;
			}

			$first = static::regularizeEngName($first);
			$last  = static::regularizeEngName($last);

			$name = array(
				'first' => $first,
				'last'  => $last
			);

			if (!in_array($name, $names))
			{
				$names[] = $name;
			}
		}

		return $names;
	}

	/**
	 * cleanQuery
	 *
	 * @param $queries
	 *
	 * @return  mixed
	 */
	public static function cleanQuery($queries)
	{
		foreach ((array) $queries['eng_name'] as $key => $name)
		{
			if (empty($name['first']) && empty($name['last']))
			{
				unset($queries['eng_name'][$key]);
			}
		}

		foreach ((array) $queries['webo_url'] as $key => $url)
		{
			if (empty($url))
			{
				unset($queries['webo_url'][$key]);
			}
		}

		if (empty($queries['id']))
		{
			unset($queries['id']);
		}

		$data = array();

		$data['chinese_name'] = $queries['chinese_name'];
		$data['eng_name']     = $queries['eng_name'];
		$data['school']       = $queries['school'];
		$data['database']     = $queries['database'];
		$data['webo_url']     = $queries['webo_url'];

		return $data;
	}

	/**
	 * regularizeSchoolName
	 *
	 * @param string $name
	 *
	 * @return  array
	 */
	public static function regularizeSchoolName($name)
	{
		$name = str_replace('台', '臺', $name);

		$db = \JFactory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*')
			->from('#__csi_schools')
			->where('title = ' . $query->q($name))
			->where('state > 0');

		$result = $db->setQuery($query)->loadObject();

		if (!$result)
		{
			return array();
		}

		// Is nick name
		if ($result->parent_id)
		{
			$query->clear()
				->select('title')
				->from('#__csi_schools')
				->where('id = ' . $result->parent_id . ' OR parent_id = ' . $result->parent_id)
				->where('state > 0');
		}
		// Is main name
		else
		{
			$query->clear()
				->select('title')
				->from('#__csi_schools')
				->where('id = ' . $result->id . ' OR parent_id = ' . $result->id)
				->where('state > 0');
		}

		$names = $db->setQuery($query)->loadColumn() ? : array();

		sort($names);

		return $names;
	}

	/**
	 * getEntryQuickLink
	 *
	 * @return  string
	 */
	public static function getEntryQuickLink()
	{
		$entries = with(new DataMapper('#__csi_entries'))->findAll();

		$list = array();

		$query = array(
			'database' => array(
				"syllabus",
				"ethesys",
				"paper",
				"social",
				"wiki",
				"scholar",
				"tci",
				"webometrics"
			),

			"webo_url" => array()
		);

		foreach ($entries as $entry)
		{
			$link = Route::_('result', array('id' => $entry->id, 'q' => json_encode($query)));

			$list[] = '<li>' . \JHtml::link($link, $entry->title) . '</li>';
		}

		return (string) new HtmlElement('ul', $list);
	}
}
 