<?php

namespace Models;

class User
{

	private $_id;
	private $_permission;
	private $_f = "";
	private $_i = "";
	private $_o = "";
	private $_phone = "";
	private $_password = "";
	private $_status = "";
	private $_email = "";
	private $_contacts = "";
	private $_date_reg = "";
	private $_active = true;

	function __construct(int $phone)
	{

		$this->_permission = PERMISSION_ROLE_ADMIN;
		$this->_f = "Иванов";
		$this->_i = "Иван";
		$this->_o = "Иванович";
		$this->_phone = new Phone($phone);

		$this->_id = 1;

	}


	public function getHashPassword(): string
	{
		return $this->_password;
	}

	public function getLastname(): string
	{
		return $this->_f;
	}

	public function getFirstanme(): string
	{
		return $this->_i;
	}

	public function getPatronymic(): string
	{
		return $this->_o;
	}


	public function getPhone(): Phone
	{
		return $this->_phone;
	}

	public function getPermission(): int
	{
		return $this->_permission;
	}

	function getID(): int
	{
		return $this->_id;
	}

	public function getFIO(bool $cut = false): string
	{
		If ($cut) {
			return $this->_f . " " . mb_substr($this->_i, 0, 1) . ". " . mb_substr($this->_o, 0, 1) . ".";
		} else {
			return $this->_f . " " . $this->_i . " " . $this->_o;
		}
	}

	public function getLFP(bool $cut = false): string
	{
		If ($cut) {
			return $this->_f . " " . mb_substr($this->_i, 0, 1) . ". " . mb_substr($this->_o, 0, 1) . ".";
		} else {
			return $this->_f . " " . $this->_i . " " . $this->_o;
		}
	}

	public function getIF(): string
	{
		return $this->_i . " " . $this->_f;
	}

	public function getFL(): string
	{
		return $this->_i . " " . $this->_f;
	}

	public function getStatus(): string
	{
		return $this->_status;
	}

}