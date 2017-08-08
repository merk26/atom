<?php

namespace Modules;

use Extension\Plates\User;
use League\Plates;


abstract class AbstractGetController implements InterfaceController
{

	/**
	 * Флаг доступа к модулю
	 * @var
	 */
	protected $_p = PERMISSION_FLAG_DEV;
	/**
	 * Объект шаблонизатора
	 * @var Plates\Engine
	 */
	protected $_t;
	/**
	 * Название модуля, берется  из namespace
	 * @var
	 */
	protected $_m;
	/**
	 * Название класса, без namespace
	 * @var mixed
	 */
	protected $_c;
	/**
	 * Переменные, которые передаются в шаблон
	 * @var array
	 */
	protected $res = array('title' => 'page');

	public final function getPermission(): int
	{
		return $this->_p;
	}

	public function response(): string
	{
		return $this->_t->render($this->_c, $this->res);
	}

	protected function init_render(): void
	{
		$this->_t = new Plates\Engine(APP_DIR . "Layouts" . DIRECTORY_SEPARATOR . $this->_m, "phtml");
		$this->_t->registerFunction('empty', function () {
			return "<p class='text-warning'>Нет данных для отображения.</p>";
		});
		$this->_t->loadExtension(new Plates\Extension\Asset(APP_DIR . "public", false));
		$this->_t->loadExtension(new User());
		$this->_t->addFolder('app', APP_DIR . "Layouts");
	}

	public final function init(array $params): void
	{
		foreach ($params as $k => $v)
			$this->$k = $v;

		$tmp = explode("\\", get_class($this));
		$this->_m = $tmp[count($tmp) - 3];
		$this->_c = end($tmp);

		$this->init_render();
	}
}