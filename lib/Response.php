<?php
namespace lib;

class Response
{
	const NOT_FOUND = 404;

	private $currentCode;

	public function __construct()
	{

	}

	public function setHttpCode($code)
	{
		$this->currentCode = $code;
	}
}