<?php

namespace Modules\auth\get;

use \Modules\AbstractGetController;
use \Models\Client;


class index extends AbstractGetController
{

	protected $_p = PERMISSION_DEFAULT;

	function process(): void
	{
		$this->res['title'] = "Вход в систему";

		if (Client::ins()->getPermission() & PERMISSION_AUTHORIZED)
			Client::location('/dashboard', true);
	}
}