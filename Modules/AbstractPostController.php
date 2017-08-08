<?php

namespace Modules;

abstract class AbstractPostController implements InterfaceController
{

	protected $_p = PERMISSION_FLAG_DEV;
	protected $_content_type = "application/json";


	public final function getPermission(): int
	{
		return $this->_p;
	}

	protected $res = array();

	public function init(array $params): void
	{
		foreach ($params as $k => $v)
			$this->$k = $v;
	}

	public final function response(): string
	{
		header('Content-Type: ' . $this->_content_type);
		return json_encode($this->res);
	}
}