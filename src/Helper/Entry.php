<?php

namespace Helper;

use DI\BaseHelper as Helper;

class Entry extends Helper
{
	public function buildKey()
	{
		$names = array(
			'黃俊傑; Chun-Chieh Huang',
			'唐牧群; Muh-Chyun Tang',
			'石之瑜; Chih-Yu Shih',
			'李安; Ang Lee',
			'陳光華; Quang-Hua Chen'
		);

		return $names[rand(0,4)];
	}
}
