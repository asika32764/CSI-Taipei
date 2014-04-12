<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Csi\Helper;


class TestHelper
{
	public static function download()
	{
		$url = 'http://www.oia.ntu.edu.tw/oia/public/share/files/oia/Courses%20Taught%20in%20English.pdf';

		$file = JPATH_ROOT . '/files/test/' . uniqid() . '.pdf';

		$fp = fopen($file, 'w');

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FILE, $fp);

		$data = curl_exec($ch);

		curl_close($ch);
		fclose($fp);

		die;
	}
}
 