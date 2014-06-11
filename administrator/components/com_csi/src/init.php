<?php
/**
 * Part of Component Csi files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

include_once JPATH_LIBRARIES . '/windwalker/src/init.php';
include_once __DIR__ . '/../vendor/autoload.php';

JLoader::registerPrefix('Csi', JPATH_BASE . '/components/com_csi');
JLoader::registerNamespace('Csi', JPATH_ADMINISTRATOR . '/components/com_csi/src');
JLoader::registerNamespace('Windwalker', __DIR__);
JLoader::register('CsiComponent', JPATH_BASE . '/components/com_csi/component.php');

// 3rd packages
// \JLoader::registerNamespace('PHPHtmlParser', JPATH_ADMINISTRATOR . '/components/com_csi/src');
