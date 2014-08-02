<?php
namespace lib;

class Application
{
	private static $_instance;

	private $_view;
	private $_config;
	private $_request;
	private $_response;
	private $_session;

	private function __construct()
	{
		// Get Config
		$host = $_SERVER['HTTP_HOST'];
		$this->_config = include 'etc/'.$host.'.php';

		// Invoke Session
		$this->_session = new Session();

		$basepath = '';
		if(isset($this->_config['application']['baseUrl'])) {
			$basepath = $this->_config['application']['baseUrl'];
		}

		// Set View - Instance
		$this->_view = new View($basepath);
		if(isset($this->_config['application']['useLayout'])) {
			$this->_view->setUseOfLayout($this->_config['application']['useLayout']);
			if(isset($this->_config['application']['defaultLayoutTemplate'])) {
				$this->_view->setLayoutPath($this->_config['application']['defaultLayoutTemplate']);
			}
		}

		// Set Request
		$this->_request = new Request($this->_config);

		// Set Respnse
		$this->_response = new Response();
	}

	/**
	 * @static
	 * @return Application
	 */
	public static function getInstance()
	{
		if(!isset(self::$_instance)) {
			self::$_instance = new Application();
		}
		return self::$_instance;
	}

	public function __clone(){
		trigger_error("Clonen ist nicht erlaubt.",E_USER_ERROR);
	}
	public function __wakeup(){
		trigger_error("WAKEUP ist nicht erlaubt.",E_USER_ERROR);
	}

	public function getView()
	{
		return $this->_view;
	}

	/**
	 * @return array
	 */
	public function getConfig()
	{
		return $this->_config;
	}

	public function getRequest()
	{
		return $this->_request;
	}

	public function getResponse()
	{
		return $this->_response;
	}

	public function getSession()
	{
		return $this->_session;
	}

	public function run()
	{
		$this->_request->proceed();
		$this->_view->render('index');
	}
}