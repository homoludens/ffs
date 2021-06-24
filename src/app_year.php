<?php

// example.com/src/app.php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

function is_leap_year($year = null) {
  if (null === $year) {
    $year = date('Y');
  }

  return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
}

class LeapYearController
{

  public function index($year)
  {
    if (is_leap_year($year)) {
      return new Response('Yep, this is a leap year!');
    }

    return new Response('Nope, this is not a leap year.');
  }
}


$routes = new Routing\RouteCollection();
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', [
  'year' => null,
  '_controller' => 'LeapYearController::index',
]));

return $routes;