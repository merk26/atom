<?php

namespace Core\Exception;

class NotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Not Found", 404);
    }
}