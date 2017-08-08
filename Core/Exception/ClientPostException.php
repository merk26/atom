<?php

namespace Core\Exception;

class ClientPostException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message, 1001);
    }
}