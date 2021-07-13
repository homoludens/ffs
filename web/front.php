<?php
// example.com/web/front.php
require_once __DIR__.'/../vendor/autoload.php';


use Symfony\Component\HttpFoundation\Request;


ini_set('display_errors', 1);
error_reporting(-1);

// example.com/web/front.php
require_once __DIR__.'/../vendor/autoload.php';


$request = Request::createFromGlobals();
$routes = include __DIR__.'/../src/app_year.php';

$framework = new Simplex\Framework($routes);

$framework->handle($request)->send();
