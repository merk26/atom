<?php

namespace Modules\auth\get;

use \Modules\AbstractGetController;
use \Models\Client;

class logout extends AbstractGetController
{
	protected $_p = PERMISSION_DEFAULT;
	protected $remember = false;
	protected $cookie = false;

	function process(): void
	{

		if ($this->remember)
			setcookie('uid', Client::ins()->user()->getID(), time() + 3600 * 24 * 7, "/");

		session_destroy();
		Client::location("/", true);
	}

	protected function init_render(): void
	{
		//not init render
	}

}