<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

// No direct access
defined('_JEXEC') or die;

use Windwalker\Helper\PathHelper;
use Windwalker\Router\CmsRouter;
use Windwalker\Router\Helper\RoutingHelper;

include_once JPATH_LIBRARIES . '/windwalker/Windwalker/init.php';

JLoader::registerNamespace('Windwalker', PathHelper::getAdmin('com_csi') . '/src');

// Prepare Router
$router = CmsRouter::getInstance();

// Register routing config and inject Router object into it.
$router = RoutingHelper::registerRouting($router, 'com_csi');

/**
 * 轉換網址
 *
 * ?view=items&category_id=23 => /category/23
 * ?views=item&category_id=39 => /category/39
 * ?view=item&title=abc&id=18 => /item/abc
 *
 * @param array &$query
 *
 * @return array
 */
function CsiBuildRoute(&$query)
{
	return array();
}

/**
 * 轉換網址
 *
 * /category/23 => array("category_id" => 23,  "view"  => "items");
 * /category/39 => array("category_id" => 39,  "view"  => "items");
 * /item/abc    => array("id" => (int) abc_id, "title" => "abc", "view" => "item");
 *
 * @param array $segments
 *
 * @return array
 */
function CsiParseRoute($segments)
{
	$router = CmsRouter::getInstance();

	// OK, let's fetch view name.
	$task = $router->getTask(implode('/', $segments));

	if ($task)
	{
		return array('task' => $task);
	}

	return array();
}
