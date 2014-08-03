<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\User;

/**
 * The UserHelper class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class UserHelper
{
	/**
	 * isLogin
	 *
	 * @return  boolean
	 */
	public static function isLogin()
	{
		return !\JFactory::getUser()->guest;
	}

	/**
	 * goToLogin
	 *
	 * @return  void
	 */
	public static function goToLogin()
	{
		$url = \JRoute::_('index.php?option=com_users&view=login&return=' . base64_encode(\JUri::getInstance()));

		\JFactory::getApplication()->redirect($url);

		exit('Go to login');
	}

	/**
	 * takeUserToLogin
	 *
	 * @return  void
	 */
	public static function takeUserToLogin()
	{
		if (!static::isLogin())
		{
			static::goToLogin();
		}
	}
}
 