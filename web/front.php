<?php
// example.com/web/front.php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;
use Symfony\Component\DependencyInjection\Reference;

$routes = include __DIR__.'/../src/app_year.php';
$container = include __DIR__.'/../src/container.php';

// ...
use Simplex\StringResponseListener;

$container->register('listener.string_response', StringResponseListener::class);
$container->getDefinition('dispatcher')
  ->addMethodCall('addSubscriber', [new Reference('listener.string_response')])
;

//$container->setParameter('debug', true);
//echo $container->getParameter('debug');

// ...
$container->register('listener.response', HttpKernel\EventListener\ResponseListener::class)
  ->setArguments(['%charset%'])
;
$container->setParameter('charset', 'UTF-8');

// ...
$container->register('matcher', Routing\Matcher\UrlMatcher::class)
  ->setArguments(['%routes%', new Reference('context')])
;

$container->setParameter('routes', include __DIR__.'/../src/app_year.php');

$request = Request::createFromGlobals();



$response = $container->get('framework')->handle($request);

$response->send();
