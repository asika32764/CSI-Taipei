<?php

require 'vendor/autoload.php';

$config = require 'config.php';

$app = new \Slim\Slim($config);

$app->get('/:path+', function($path) use($app){
    $app->render('abc.twig', array('path' => $path));
});

$app->run();