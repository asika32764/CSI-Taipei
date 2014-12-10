<?php
/**
 * Part of devsite project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */


define('_JEXEC', 1);

// Fix magic quotes.
ini_set('magic_quotes_runtime', 0);

// Maximise error reporting.
ini_set('zend.ze1_compatibility_mode', '0');
error_reporting(E_ALL & ~(E_STRICT|E_USER_DEPRECATED));
ini_set('display_errors', 1);

// Set fixed precision value to avoid round related issues
ini_set('precision', 14);

/*
 * Ensure that required path constants are defined.  These can be overridden within the phpunit.xml file
 * if you chose to create a custom version of that file.
 */
if (!defined('JPATH_TESTS'))
{
	define('JPATH_TESTS', __DIR__);
}
if (!defined('JPATH_TEST_DATABASE'))
{
	define('JPATH_TEST_DATABASE', JPATH_TESTS . '/stubs/database');
}
if (!defined('JPATH_TEST_STUBS'))
{
	define('JPATH_TEST_STUBS', JPATH_TESTS . '/stubs');
}
if (!defined('JPATH_PLATFORM'))
{
	define('JPATH_PLATFORM', realpath(JPATH_TESTS . '/../../libraries'));
}
if (!defined('JPATH_LIBRARIES'))
{
	define('JPATH_LIBRARIES', JPATH_PLATFORM);
}
if (!defined('JPATH_BASE'))
{
	define('JPATH_BASE', realpath(JPATH_TESTS . '/../..'));
}
if (!defined('JPATH_ROOT'))
{
	define('JPATH_ROOT', realpath(JPATH_BASE));
}
if (!defined('JPATH_CACHE'))
{
	define('JPATH_CACHE', JPATH_BASE . '/cache');
}
if (!defined('JPATH_CONFIGURATION'))
{
	define('JPATH_CONFIGURATION', JPATH_BASE);
}
if (!defined('JPATH_SITE'))
{
	define('JPATH_SITE', JPATH_ROOT);
}
if (!defined('JPATH_ADMINISTRATOR'))
{
	define('JPATH_ADMINISTRATOR', JPATH_ROOT . '/administrator');
}
if (!defined('JPATH_INSTALLATION'))
{
	define('JPATH_INSTALLATION', JPATH_ROOT . '/installation');
}
if (!defined('JPATH_MANIFESTS'))
{
	define('JPATH_MANIFESTS', JPATH_ADMINISTRATOR . '/manifests');
}
if (!defined('JPATH_PLUGINS'))
{
	define('JPATH_PLUGINS', JPATH_BASE . '/plugins');
}
if (!defined('JPATH_THEMES'))
{
	define('JPATH_THEMES', JPATH_BASE . '/templates');
}

//// Import the platform in legacy mode.
//require_once JPATH_PLATFORM . '/import.php';
//
//// Force library to be in JError legacy mode
//JError::setErrorHandling(E_NOTICE, 'message');
//JError::setErrorHandling(E_WARNING, 'message');
//
//// Bootstrap the CMS libraries.
//require_once JPATH_PLATFORM . '/cms.php';

include_once JPATH_BASE . '/includes/framework.php';

// Include Composer
include_once __DIR__ . '/../vendor/autoload.php';

// Restore error handler
//restore_error_handler();
//restore_exception_handler();

// Fake HTTP
$_SERVER['HTTP_HOST'] = 'windwalker.io';

// Init Application
$app = JFactory::getApplication('administrator');

// Load Classes
JLoader::registerNamespace('SMS', __DIR__);

// Load Config
if (is_file(__DIR__ . '/../etc/config.json'))
{
	$config = JFactory::getConfig();

	$config->loadFile(__DIR__ . '/../etc/config.json');
}

// Include Windwalker
//$windwalker = JPATH_LIBRARIES . '/windwalker/src/init.php';
//
//if (is_file($windwalker))
//{
//	include_once $windwalker;
//}
