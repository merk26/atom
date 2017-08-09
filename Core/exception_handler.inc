<?php

namespace Core;

set_exception_handler(function (\Throwable $e) {

    $code = 400;
    $message = "Internal Server Error";
    switch ($e->getCode()) {
        case 403:
        case 404:
        case 400:
        case 500:
        case 503:
            Log::F()->debug("Код: " . $e->getCode() . ", сообщение: " . $e->getMessage() . ' в ' . $e->getFile() . ', строка ' . $e->getLine() . "\n");
            //$code = $e->getCode();
           // $message = $e->getMessage();
            break;
        case 1001:
            Log::F()->debug("Код: " . $e->getCode() . ", сообщение: " . $e->getMessage() . ' в ' . $e->getFile() . ', строка ' . $e->getLine() . "\n");
            exit(json_encode(array('error' => array('code' => $e->getCode(), 'message' => $e->getMessage()))));
            break;
        default:
            Log::F()->critical("Код: " . $e->getCode() . ", сообщение: " . $e->getMessage() . ' в ' . $e->getFile() . ', строка ' . $e->getLine() . "\n");
    }

    if ($_SERVER['REQUEST_METHOD'] == "GET")
        require_once APP_DIR . "Layouts" . DIRECTORY_SEPARATOR . "static_" . $code . ".phtml";
    else
        exit(json_encode(array('error' => array('code' => $code, 'message' => $message))));
});