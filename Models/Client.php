<?php

namespace Models;

use Core\Log;

class Client
{
	private static $_this;
	private $_permission;
	private $_user;

	private function __construct()
	{
		if (!empty($_SESSION['user'])) {
			$this->_user = &$_SESSION['user'];
			$this->_permission = $this->user()->getPermission() | PERMISSION_AUTHORIZED | PERMISSION_DEFAULT;
		}
	}

	static function ins(): Client
	{
		if (self::$_this == null)
			self::$_this = new Client();
		return self::$_this;
	}

	function user(): User
	{
		return $this->_user;
	}

	function getPermission(): int
	{
		if (empty($this->_user))
			return PERMISSION_DEFAULT;
		else
			return $this->_permission;
	}

	private function __clone()
	{
	}
    static function location($url, bool $http_header = false)
    {
        Log::F()->debug('Открываю адрес: ' . $url);
        if ($http_header)
            header("Location: " . trim($url));
        else
            echo '<meta http-equiv="refresh" content="0;URL=' . $url . '" />';
        exit;
    }
}