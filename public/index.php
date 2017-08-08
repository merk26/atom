<?php

namespace Core;

//use \Core\Database;
//use \Configurations\MainDatabase as c;

use Core\Exception\ForbiddenException;
use Core\Exception\NotFoundException;
use Models\Client;

$time_start = microtime(true);
error_reporting(E_ALL);
ini_set('display_errors', 'On');

define('APP_SESSION_LIFE_TIME', 2700);
define('APP_DIR', __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR);

setlocale(LC_ALL, 'ru_RU.UTF-8');
date_default_timezone_set('Asia/Krasnoyarsk');

require_once APP_DIR . "Configurations" . DIRECTORY_SEPARATOR . "permission.inc";

function init_autoload($dir, $ext = "php")
{
    spl_autoload_register(function ($class) use ($dir, $ext) {
        $class = ltrim($class, '\\');
        if ($lastNsPos = strripos($class, '\\')) {
            $namespace = substr($class, 0, $lastNsPos);
            $class = substr($class, $lastNsPos + 1);
            $dir .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR . $class . '.' . $ext;
        }
        if (is_file($dir)) require_once $dir;
    });
}

//main autoload
init_autoload(APP_DIR);
//vendor autoload
init_autoload(APP_DIR . "vendor" . DIRECTORY_SEPARATOR);

ini_set('session.gc_maxlifetime', APP_SESSION_LIFE_TIME);
session_start();

Log::F()->setMinLevel('debug');

require_once APP_DIR . "Core" . DIRECTORY_SEPARATOR . "error_handler.inc";
require_once APP_DIR . "Core" . DIRECTORY_SEPARATOR . "exception_handler.inc";

ini_set('display_errors', 'Off');

$method = ($_SERVER['REQUEST_METHOD'] == "GET") ? "get" : "post";
$url = filter_input(INPUT_SERVER, 'REQUEST_URI');
$module = 'dashboard';
$controller = 'index';
$params = array();

Log::F()->debug('Разбираю запрос... (метод: ' . $method . ", url: " . $url . ")");

if ($url != '/') {
    $uri_parts = explode('/', trim(parse_url($url, PHP_URL_PATH), ' /'));
    $cnt = count($uri_parts);
    $module = array_shift($uri_parts); // Получили имя модуля

    if ($cnt > 1)
        $controller = array_shift($uri_parts); // Получили имя контроллера

    //проверяем на месте ли файл модуля
    if (!is_file(APP_DIR . 'Modules' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $method . DIRECTORY_SEPARATOR . $controller . '.php'))
        throw new NotFoundException();

    // Получили в $params параметры запроса
    for ($i = 0; $i < count($uri_parts); $i++)
        $params[$uri_parts[$i]] = $uri_parts[$i + 1] ?? $uri_parts[$i++];
    if (isset($_REQUEST))
        $params = array_merge($params, $_REQUEST);
}

$class_name = "\\Modules\\" . $module . "\\" . $method . "\\" . $controller;
$obj = new  $class_name();
if (Client::ins()->getPermission() & $obj->getPermission()) {
    Log::F()->debug('Исполняю код контроллера. (' . $class_name . ', параметры ' . json_encode($params) . '), URL: ' . $url);
    $obj->init($params);
    $obj->process();
    echo $obj->response();
} elseif (Client::ins()->getPermission() & PERMISSION_AUTHORIZED)
    throw new ForbiddenException();
else
    Client::location("/auth", true);

//new Database(c::host, c::user, c::pass, c::db, c::port, c::charset);
Log::F()->debug("Приложение выполнено. Затраченное время: " . number_format(microtime(true) - $time_start, 3) . " sec.\r");
