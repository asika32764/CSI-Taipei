<?php

namespace Helper;

use DI\BaseHelper as Helper;

class Task extends Helper
{
	public $names = array(
		'黃俊傑; Chun-Chieh Huang',
		'唐牧群; Muh-Chyun Tang',
		'石之瑜; Chih-Yu Shih',
		'李安; Ang Lee',
		'陳光華; Quang-Hua Chen'
	);

	public function buildTitle()
	{
		return $this->names[rand(0,4)];
	}
}
