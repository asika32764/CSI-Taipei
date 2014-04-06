<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Model;

use Csi\Helper\PageHelper;
use Windwalker\Helper\CurlHelper;

/**
 * Class PageModel
 *
 * @since 1.0
 */
class PageModel extends \JModelDatabase
{
	/**
	 * download
	 *
	 * @param int    $id
	 * @param string $url
	 *
	 * @return  bool
	 *
	 * @throws \RuntimeException
	 */
	public function download($id, $url)
	{
		$path = PageHelper::getFilePath($id);

		$result = CurlHelper::download($url, $path);

		if (!$result->getError())
		{
			return true;
		}
		else
		{
			throw new \RuntimeException($result->getError());
		}
	}
}
 