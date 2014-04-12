<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Model;

use Csi\Helper\PageHelper;
use Windwalker\Data\Data;
use Windwalker\Helper\CurlHelper;
use Windwalker\Helper\UriHelper;

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
	 * @param Data $page
	 *
	 * @return  bool
	 *
	 * @throws \RuntimeException
	 */
	public function download(Data $page)
	{
		$path = PageHelper::getFilePath($page->id, $page->filetype);

		$result = CurlHelper::download(UriHelper::safe($page->url), $path);

		if (!$result || !$result->getError())
		{
			return true;
		}
		else
		{
			throw new \RuntimeException($result->getError());
		}
	}
}
 