<?php
namespace app\controller;

use lib\ControllerAbstract;
use lib\Application;

class Authenticate extends ControllerAbstract
{
	public function login()
	{
		$this->getView()->action = $this->getRequest()->getRequestUri();
		$this->getView()->values = array(
			'pass' => '',
			'user' => '',
		);
		if($this->getRequest()->isPost()) {
			$username = htmlspecialchars($this->getRequest()->getParam('user'));
			$password = htmlspecialchars($this->getRequest()->getParam('password'));

			$config = Application::getInstance()->getConfig();
			if(isset($config['user'][$username])) {

				// Wenn das zutrifft stimmt was nicht mit User-Konfiguration in der Config-Datei
				if(!isset($config['user'][$username]['password'])) {
					trigger_error("Der User ist falsch konfiguriert. Bitte wenden Sie sich an den Administrator",E_USER_ERROR);
				}

				// Überprüfe ob der  MD5-Hash der User-Eingabe des Passwords mit der gespeicherten Version übereinstimmt
				if(md5($password) == $config['user'][$username]['password']) {
					$this->getSession()->setUserIsLoggedIn($username,$config['user'][$username]);
					$this->getSession()->appendSuccessMessage("Willkommen, {$config['user'][$username]['firstname']} {$config['user'][$username]['lastname']}");
					$this->getSession()->appendSuccessMessage($config['user'][$username]['msg']);
					if($this->getView()->action == '/' || $this->getView()->action == 'authenticate/login' || 'authenticate/logout') {
						$this->getRequest()->redirectTo('index','index','full');
					} else {
						$this->getView()->render($this->getView()->action);
					}
				} else {
					$this->getSession()->appendErrorMessage('Ihre Eingaben sind leider fehlerhaft');
					$this->getView()->errors = array(
						'pwField'
					);
				}
			} else {
				$this->getSession()->appendErrorMessage('Benutzername ist unbekannt. Überprüfen Sie Ihre Schreibweise');
				$this->getView()->errors = array(
					'userField'
				);
			}
			$this->getView()->values['pass'] = $password;
			$this->getView()->values['user'] = $username;
		}
		$this->getView()->render('authenticate/login');
	}

	public function logout()
	{
		unset($_SESSION['user']);
		$this->getSession()->appendSuccessMessage("Sie haben sich erfolgreich abgemeldet");
		$this->getRequest()->redirectTo('index','index','full');
	}
}