<?php
// framework/index.php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

$name = $request->get('name', 'World');



if ($myIp === $request->getClientIp()) {
  // the client is a known one, so give it some more privilege
}



$response = new Response(sprintf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8')));

$response->send();

$response = new Response();

