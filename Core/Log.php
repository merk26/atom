<?php

namespace Core;

use \Apix\Log\Logger;

class Log
{
	private static $_f;

	private function __construct()
	{

	}

	static function F(): Logger\File
	{
		if (self::$_f == null)
			self::$_f = new Logger\File($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR . date('Y-m-d') . ".psr3.log");
		return self::$_f;
	}


	private function __clone()
	{
	}
}