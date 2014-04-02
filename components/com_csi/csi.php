<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_csi
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

include_once JPATH_LIBRARIES . '/windwalker/Windwalker/init.php';

JLoader::registerPrefix('Csi', JPATH_COMPONENT);
JLoader::registerNamespace('Csi', JPATH_COMPONENT_ADMINISTRATOR . '/src');
JLoader::register('CsiComponent', JPATH_COMPONENT . '/component.php');

echo with(new CsiComponent)->execute();
