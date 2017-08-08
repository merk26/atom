<?php

namespace Extension\Plates;

use \League\Plates\Engine;
use \League\Plates\Extension\ExtensionInterface;
use \Models\Client;

class User implements ExtensionInterface
{


	public function register(Engine $engine)
	{
		$engine->registerFunction('user', [$this, 'getUser']);
	}

	public function getUser(): \Models\User
	{
		return Client::ins()->user();
	}

}

