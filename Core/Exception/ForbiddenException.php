<?php

namespace Core\Exception;

class ForbiddenException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Forbidden", 403);
    }
}