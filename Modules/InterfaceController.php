<?php

namespace Modules;
interface InterfaceController
{

	/**
	 * Возвращает флаг доступа к модулю
	 * @var
	 */

	function getPermission(): int;

	/**
	 * Инициализация модуля
	 * @param array $params
	 */
	function init(array $params): void;

	/**
	 * Основная рабочая функция модуля
	 */
	function process(): void;

	/**
	 * Возвращает результат работы контроллера
	 * @return string
	 */
	function response(): string;

}