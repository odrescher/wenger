<?php
namespace lib;

abstract class ControllerAbstract
{
	private $response;
	private $request;
	private $view;
	private $session;

	public function __construct()
	{
		$this->request = Application::getInstance()->getRequest();
		$this->response = Application::getInstance()->getResponse();
		$this->view = Application::getInstance()->getView();
		$this->session = Application::getInstance()->getSession();
	}

	/**
	 * @return Request
	 */
	public function getRequest()
	{
		return $this->request;
	}
	/**
	 * @return Response
	 */
	public function getResponse()
	{
		return $this->response;
	}
	/**
	 * @return View
	 */
	public function getView()
	{
		return $this->view;
	}
	/**
	 * @return Session
	 */
	public function getSession()
	{
		return $this->session;
	}
}