<?php

namespace Core\Exception;

class InternalServerErrorException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Internal Server Error", 500);
    }
}