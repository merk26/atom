<?php

namespace Core\Exception;

class BadRequestException extends \Exception
{
    public function __construct($message = "Bad Request")
    {
        parent::__construct($message, 400);
    }
}