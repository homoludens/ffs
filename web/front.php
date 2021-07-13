<?php
// example.com/web/front.php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;

$request = Request::createFromGlobals();
$requestStack = new RequestStack();
$routes = include __DIR__.'/../src/app_year.php';

$context = new Routing\RequestContext();
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

$controllerResolver = new HttpKernel\Controller\ControllerResolver();
$argumentResolver = new HttpKernel\Controller\ArgumentResolver();

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new HttpKernel\EventListener\RouterListener($matcher, $requestStack));

$framework = new Simplex\Framework($dispatcher, $controllerResolver, $requestStack, $argumentResolver);

// error management
//$errorHandler = function (Symfony\Component\ErrorHandler\Exception\FlattenException $exception) {
//  $msg = 'Something went wrong! ('.$exception->getMessage().')';
//
//  return new Response($msg, $exception->getStatusCode());
//};
//$dispatcher->addSubscriber(new HttpKernel\EventListener\ErrorListener($errorHandler));

//
$listener = new HttpKernel\EventListener\ErrorListener(
  'Calendar\Controller\ErrorController::exception'
);
$dispatcher->addSubscriber($listener);

//Response::prepare() method, which ensures that a Response is compliant with the HTTP specification
$dispatcher->addSubscriber(new HttpKernel\EventListener\ResponseListener('UTF-8'));

//streamed responses
$dispatcher->addSubscriber(new HttpKernel\EventListener\StreamedResponseListener());

$dispatcher->addSubscriber(new Simplex\StringResponseListener());

$response = $framework->handle($request);
$response->send();
