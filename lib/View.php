<?php
namespace lib;

class View
{
	private $viewDir;
	private $content;
	private $useLayout;
	private $layoutPath;
	private $templateExtension = 'phtml';
	private $baseUrl;

	private $allowedTemplateExtenstion = array(
		'phtml',
		'html',
		'json'
	);


	public function __construct($baseUrl = '')
	{
		$this->viewDir = dirname(__FILE__).'/../view/';
		$this->baseUrl = $baseUrl;
	}

	public function render($template)
	{
		if(!Application::getInstance()->getSession()->isUserLoggedIn() && $template != 'authenticate/login') {
			Application::getInstance()->getSession()->login();
		}
		$realPath = $this->_templateExists($template);

		if($this->_layoutExists()) {
			$this->content = $realPath;
			include $this->_templateExists($this->layoutPath);
		} else {
			include $realPath;
		}
		exit;
	}

	public function renderPart($template)
	{
		return $this->_templateExists($template);
	}


	private function _templateExists($template)
	{
		$path = $this->viewDir.$template.".".$this->templateExtension;
		if( !file_exists($path) ) {
			trigger_error("Template {$path} does not exist",E_USER_ERROR);
		}
		return realpath($path);
	}

	private function _layoutExists()
	{
		if(!$this->useLayout) {
			return FALSE;
		}
		$path = $this->viewDir.$this->layoutPath.".phtml";
		if( !file_exists($path) ) {
			trigger_error("Layout-Path {$path} does not exist",E_USER_ERROR);
		}
		return TRUE;
	}

	public function setLayoutPath($layoutPath)
	{
		$this->layoutPath = $layoutPath;
	}

	public function getLayoutPath()
	{
		return $this->layoutPath;
	}

	public function setUseOfLayout($useLayout = TRUE)
	{

		$this->useLayout = ($useLayout) ? TRUE : FALSE;
	}

	public function setTemplateExtension($templateExtension)
	{
		if(!in_array($templateExtension,$this->allowedTemplateExtenstion)) {
			trigger_error("TemplateExtension {$templateExtension} is not allowed",E_USER_ERROR);
		}
		$this->templateExtension = $templateExtension;
	}

	public function getBaseUrl()
	{
		return $this->baseUrl;
	}

	public function createLink($controller, $action , $params = array(), $anchor = '')
	{
		$link = '';
		if(!empty($this->baseUrl)) {
			$link .= $this->baseUrl;
		}
		if(mb_substr($link,-1,1,'UTF-8') != '/') {
			$link .= "/";
		}


		$link .= $controller;
		if($action != 'index') {
			$link .= "/".$action;
		}
		$link .= (!empty($anchor)) ? "#".$anchor : '';
		$first = true;
		foreach ($params as $key => $param) {
			if($first) {
				$link .= "?";
				$first = false;
			} else {
				$link .='&';
			}
			$link .= "{$key}={$param}";
		}
		return $link;
	}
}