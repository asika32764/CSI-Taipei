<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

include_once __DIR__ . '/../libraries/jconsole/vendor/autoload.php';

$path = __DIR__ . '/../administrator/components/com_csi/etc';

$config = new \Joomla\Registry\Registry;

$config->loadFile($path . '/config.json');

$config = $config->toArray();

echo \Symfony\Component\Yaml\Yaml::dump($config, 5);
