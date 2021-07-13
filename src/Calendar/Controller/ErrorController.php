<?php

// example.com/src/Calendar/Controller/ErrorController.php
namespace Calendar\Controller;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ErrorController
{
  public function exception(FlattenException $exception)
  {
    $msg = 'Something went wrong! ('.$exception->getMessage().')';

    return new Response($msg, $exception->getStatusCode());
  }
}
