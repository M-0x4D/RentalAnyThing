<?php

namespace MvcCore\Rental\Exceptions;

class InvalidRequestException extends \Exception
{
    protected $message = "this request is not found";
}
