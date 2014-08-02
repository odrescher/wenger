<?php
namespace lib;

class Session
{

	public function __construct()
	{
		session_start();
	}

	public function isUserLoggedIn()
	{
		$config = Application::getInstance()->getConfig();
		if($config['user'] === FALSE){
			return true;
		}
		if(isset($_SESSION['user'])) {
			$keys = array_keys($_SESSION['user']);
			foreach($keys as $username) {
				if(isset($config['user'][$username])) {
					if(($_SESSION['user'][$username]['logintime']+$config['application']['loginttl']) < time()) {
						$this->appendErrorMessage("Ihre Login-Session ist abgelaufen");
						unset($_SESSION['user']);
					} else {
						$_SESSION['user'][$username]['logintime'] = time();
						return true;
					}
				}
			}
		}
		return false;
	}

	public function setUserIsLoggedIn($user,$data)
	{
		$data['logintime'] = time();
		$_SESSION['user'][$user] = $data;
	}

	public function login()
	{
		Application::getInstance()->getRequest()->redirectTo('authenticate','login');
	}
	public function logout()
	{
		Application::getInstance()->getRequest()->redirectTo('authenticate','logout');
	}

	public function getData()
	{
		return $_SESSION;
	}

	public function getMessages()
	{
		if(isset($_SESSION['messages'])) {
			return $_SESSION['messages'];
		}
		return false;
	}

	public function appendErrorMessage($msg)
	{
		if(mb_strlen($msg,'UTF-8') > 170) {
			$triggermsg = htmlspecialchars(mb_substr(trim($msg),0,20)).'...';
			trigger_error("Error-Message '{$triggermsg}' is too long. Only 170 Characters allowed", E_USER_WARNING);
			$_SESSION['messages']['error'][] = htmlspecialchars(mb_substr(trim($msg),0,170))."...";
		} else {
			$_SESSION['messages']['error'][] = htmlspecialchars(trim($msg));
		}
	}
	public function appendSuccessMessage($msg)
	{
		if(mb_strlen($msg,'UTF-8') > 170) {
			$triggermsg = htmlspecialchars(mb_substr(trim($msg),0,20)).'...';
			trigger_error("Success-Message '{$triggermsg}' is too long. Only 170 Characters allowed", E_USER_WARNING);
			$_SESSION['messages']['success'][] = htmlspecialchars(mb_substr(trim($msg),0,170))."...";
		} else {
			$_SESSION['messages']['success'][] = htmlspecialchars(trim($msg));
		}
	}

	/**
	 * @return bool|array
	 */
	public function getErrorMessages()
	{
		if(isset($_SESSION['messages']['error'])) {
			$mesg = $_SESSION['messages']['error'];
			unset($_SESSION['messages']['error']);
			return $mesg;
		}
		return false;
	}
	/**
	 * @return bool|array
	 */
	public function getSuccessMessages()
	{
		if(isset($_SESSION['messages']['success'])) {
			$mesg = $_SESSION['messages']['success'];
			unset($_SESSION['messages']['success']);
			return $mesg;
		}
		return false;
	}

	public function hasMessages()
	{
		return ( isset($_SESSION['messages']['success']) || isset($_SESSION['messages']['error']));
	}

	public function clearMessages()
	{
		unset($_SESSION['messages']);
	}

}