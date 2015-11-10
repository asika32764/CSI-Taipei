<?php

die;

$url = 'http://tci.ncl.edu.tw/cgi-bin/gs32/gsweb.cgi?o=dnclresource&tcihsspage=tcisearcharea&loadingjs=1&ssoauth=1&cache=' . time();

$http = JHttpFactory::getHttp();

$res = $http->get($url);

echo $res->body;
