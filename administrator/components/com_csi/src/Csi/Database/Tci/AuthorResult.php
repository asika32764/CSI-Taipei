<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Database\Tci;

use Csi\Database\AbstractCountResult;

/**
 * The AuthorResult class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class AuthorResult extends AbstractCountResult
{
	/**
	 * Property name.
	 *
	 * @var  string
	 */
	protected $name = 'author';

	/**
	 * Property type.
	 *
	 * @var  string
	 */
	protected $type = 'task';
}
 