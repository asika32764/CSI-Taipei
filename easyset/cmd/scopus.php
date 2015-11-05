<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

die;

$key = '';
$token = '';

$http = new \Windwalker\Http\HttpClient;

//$authUrl = 'http://api.elsevier.com/authenticate?platform=SCOPUS';
//
//$response = $http->get($authUrl, [], [
//	'X-ELS-APIKey' => $key
//]);
//
//ak::show($result = json_decode($response->getBody()->__toString()));

$url = 'http://api.elsevier.com/content/search/scopus';

$response = $http->get($url, [
	'apiKey' => $key,
	'query' => 'AUTH(Simon)'
	// 'query' => urlencode('au-id(Muhchyun, Tang)')
]);

ak::show(json_decode($response->getBody()->__toString()));
