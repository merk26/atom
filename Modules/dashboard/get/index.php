<?php

namespace Modules\dashboard\get;

use \Modules\AbstractGetController;

class index extends AbstractGetController
{
	protected $_p = PERMISSION_AUTHORIZED;

	function process(): void
	{
		$this->res['title'] = "Главная";
	}
}