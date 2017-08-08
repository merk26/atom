<?php

namespace Core;

use Core\Exception\InternalServerErrorException;

set_error_handler(function ($code, $message, $file, $line) {
    if (!(error_reporting() & $code))
        return false;
    switch ($code) {
        case E_ERROR:
        case E_PARSE:
        case E_CORE_ERROR:
        case E_COMPILE_ERROR:
        case E_USER_ERROR:
            Log::F()->critical("Код: " . $code . ", сообщение: " . $message . ' в ' . $file . ', строка ' . $line);
            throw new InternalServerErrorException();
            break;
        case E_WARNING :
        case E_CORE_WARNING:
        case E_COMPILE_WARNING:
        case E_USER_WARNING:
            Log::F()->warning("Код: " . $code . ", сообщение: " . $message . ' в ' . $file . ', строка ' . $line);
            break;
        default:
            Log::F()->notice("Код: " . $code . ", сообщение: " . $message . ' в ' . $file . ', строка ' . $line);
    }
    return true;
});