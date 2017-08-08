<?php

namespace Models;

class Phone
{
	private $phone = null;
	private $valid;

	public function __construct($phone)
	{
		$this->phone = $phone;

		$this->phone = preg_replace('/[^0-9]/', '', $this->phone);
		$l = strlen($this->phone);
		if ($l > 10)
			$this->phone = substr($this->phone, -10);

		$this->valid = (strlen($this->phone) === 10);

		if (!$this->valid)
			$this->phone = '';
	}

	public function __toString(): string
	{
		return $this->phone;
	}

	public function IsValid(): bool
	{
		return $this->valid;
	}
}