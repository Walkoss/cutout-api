<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

## https://github.com/EnMarche/en-marche.fr/blob/master/web/app_dev.php
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'], true) && false === getenv('SYMFONY_ALLOW_APPDEV')) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';
Debug::enable();

$kernel = new AppKernel('dev', true);
if (PHP_VERSION_ID < 70000) {
    $kernel->loadClassCache();
}
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
