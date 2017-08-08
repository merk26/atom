<?php

namespace Core\Exception;

class ServiceUnavailableException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Service Unavailable", 403);
    }
}