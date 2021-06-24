<?php

// example.com/src/app.php
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('hello', new Routing\Route('/hello/{name}', [
  'name' => 'World',
  '_controller' => 'render_template',
]));

$routes->add('bye', new Routing\Route('/bye'));

return $routes;