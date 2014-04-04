<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Engine;

/**
 * Class AbstractEngine
 *
 * @since 1.0
 */
class AbstractEngine extends \JModelDatabase
{
	/**
	 * Property pages.
	 *
	 * @var  int
	 */
	public $pages = 0 ;

	/**
	 * Property links.
	 *
	 * @var  int
	 */
	public $links = 0 ;

	/**
	 * Property host.
	 *
	 * @var  string
	 */
	protected $host = '';

	/**
	 * Property path.
	 *
	 * @var  string
	 */
	public $path = '' ;

	/**
	 * Property query.
	 *
	 * @var  array
	 */
	public $query = array() ;

	/**
	 * getInstance
	 *
	 * @param string $name
	 *
	 * @return  AbstractEngine
	 */
	public static function getInstance($name)
	{
		$class = sprintf('Csi\\Engine\\%sEngine', ucfirst($name));

		return new $class;
	}

	public function getPageList()
	{
	}
}
 