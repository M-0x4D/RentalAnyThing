<?php

namespace MvcCore\Rental\Exceptions;

class RouteNotFoundException extends \Exception
{
    protected $message = "This route is not found";
}
