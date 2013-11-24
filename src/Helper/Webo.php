<?php

namespace Helper;

use DI\BaseHelper as Helper;

class Webo extends Helper
{
	public $engines = array(
		'Google',
		'Bing'
	);

	public $urls = array(
		'http://asikart.com',
		'http://asika.tw',
		'http://google.com',
		'http://mydesy.com',
		'http://ntu.edu.tw'
	);

	public function getEngines()
	{
		return $this->engines;
	}

	public function getUrls()
	{
		return $this->urls;
	}
}
