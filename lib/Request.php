<?php
namespace lib;

class Request
{
	private $params = array();
	private $controller;
	private $action;
	private $method;
	private $requestUri;
	private $hostName;

	public function __construct($config)
	{
		if($_REQUEST) {
			$this->params = $_REQUEST;
		}

		if(isset($_SERVER['REQUEST_METHOD'])) {
			$this->method = $_SERVER['REQUEST_METHOD'];
		}
		if(isset($_SERVER['REQUEST_URI'])) {
			$this->requestUri = $_SERVER['REQUEST_URI'];
		}
		if(isset($_SERVER['HTTP_HOST'])) {
			$this->hostName = $_SERVER['HTTP_HOST'];
		}

		if(isset($_SERVER['REQUEST_URI'])) {
			$controllerAction = preg_split('/[\/\?]/',$_SERVER['REQUEST_URI'],-1,PREG_SPLIT_NO_EMPTY);
			if(!$controllerAction) {
				$this->controller 	= (isset($config['application']['defaultController']))
					? $config['application']['defaultController']
					: 'index';
				$this->action 		= (isset($config['application']['defaultAction']))
					? $config['application']['defaultAction']
					: 'index';
			} else {
				if(isset($controllerAction[0])) {
					$this->controller = $controllerAction[0];
				}
				if(isset($controllerAction[1])) {
					$this->action = $controllerAction[1];
				}
			}
		} else {
			$this->controller 	= (isset($config['application']['defaultController']))
				? $config['application']['defaultController']
				: 'index';
			$this->action 		= (isset($config['application']['defaultAction']))
				? $config['application']['defaultAction']
				: 'index';
		}
	}

	public function getParam($key)
	{
		if(isset($this->params[$key])) {
			return $this->params[$key];
		}
		return NULL;
	}

	public function getParams()
	{
		return $this->params;
	}

	public function isPost()
	{
		return ($this->method == 'POST');
	}

	public function proceed()
	{
		$cc = ucfirst($this->controller);
		$controllerClass = "app\\controller\\{$cc}";
		if(class_exists($controllerClass)) {
			$actionName = (empty($this->action)) ? 'index' : $this->action;
			$classObject = new $controllerClass();
			if(method_exists($classObject,$actionName)) {
				$classObject->$actionName();
			} else {
				trigger_error( "Action {$actionName} in Controller {$controllerClass} does not exist", E_USER_ERROR );
			}
		} else {
			trigger_error( "Controller {$controllerClass} does not exist", E_USER_ERROR );
		}
	}

	public function redirectTo($controller, $action, $type='forward', $params = array())
	{
		if( $type != 'forward' ) {
			$config = Application::getInstance()->getConfig();
			$host = $config['application']['baseUrl'];
			if($controller != 'index' && $action != 'index') {
				$host .= "/$controller/$action";
				$first = true;
				foreach($params as $key => $param) {
					if($first) {
						$host .= "?{$key}={$param}";
						$first = false;
					} else {
						$host .= "&{$key}={$param}";
					}
				}
			}
			header("Location: $host",TRUE,302);
			exit;
		}
		$this->controller = $controller;
		$this->action = $action;
		$this->proceed();
	}

	public function setAction($action)
	{
		$this->action = $action;
	}

	public function getAction()
	{
		return $this->action;
	}

	public function setController($controller)
	{
		$this->controller = $controller;
	}

	public function getController()
	{
		return $this->controller;
	}

	public function getRequestUri()
	{
		return $this->requestUri;
	}

	public function getHostName()
	{
		return $this->hostName;
	}

}