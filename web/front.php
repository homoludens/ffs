<?php

// example.com/web/front.php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\Routing\Matcher\CompiledUrlMatcher;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;

$request = Request::createFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
// $compiledRoutes is a plain PHP array that describes all routes in a performant data format
// you can (and should) cache it, typically by exporting it to a PHP file
$compiledRoutes = (new CompiledUrlMatcherDumper($routes))->getCompiledRoutes();
$matcher = new CompiledUrlMatcher($compiledRoutes, $context);


try {

  extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
  ob_start();
  include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

  $response = new Response(ob_get_clean());

} catch (Routing\Exception\ResourceNotFoundException $exception) {
  $response = new Response('Not Found', 404);
} catch (Exception $exception) {
  $response = new Response('An error occurred', 500);
}

$response->send();