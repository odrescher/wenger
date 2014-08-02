<?php
namespace lib;

class Paginator
{
	private $currentPage;
	private $allPages;
	private $pageBaseUrl;
	private $pageKeyName;
	private $maxPages = 10;
	private $rangeEntriesStart;
	private $rangeEntriesEnd;
	private $allListElements;

	public function setAllPages($allPages)
	{
		$this->allPages = $allPages;
	}

	public function getAllPages()
	{
		return $this->allPages;
	}

	public function setCurrentPage($currentPage)
	{
		$this->currentPage = $currentPage;
	}

	public function getCurrentPage()
	{
		return $this->currentPage;
	}

	public function setPageBaseUrl($pageBaseUrl)
	{
		$this->pageBaseUrl = $pageBaseUrl;
	}

	public function getPageBaseUrl()
	{
		return $this->pageBaseUrl;
	}

	public function getPageUrl($seitenZahl = NULL)
	{
		if($this->pageKeyName !== NULL && ($seitenZahl !== NULL AND ($sz = intval($seitenZahl)) > 1)) {
			if(preg_match("/(.*)\?[a-z_-]+=(.*)/ui",$this->pageBaseUrl)) {
				return $this->pageBaseUrl."&".$this->pageKeyName."=".$sz;
			}
			return $this->pageBaseUrl."?".$this->pageKeyName."=".$sz;
		}
		return $this->pageBaseUrl;
	}

	public function setPageKeyName($pageKeyName)
	{
		$this->pageKeyName = $pageKeyName;
	}

	public function getPageKeyName()
	{
		return $this->pageKeyName;
	}

	public function render($template = 'paginator/default')
	{
		$view = Application::getInstance()->getView();
		include $view->renderPart($template);
	}

	public function setMaxPages($maxPages)
	{
		$this->maxPages = $maxPages;
	}

	public function getMaxPages()
	{
		return $this->maxPages;
	}

	public function setRangeEntriesEnd($rangeEntriesEnd)
	{
		$this->rangeEntriesEnd = $rangeEntriesEnd;
	}

	public function getRangeEntriesEnd()
	{
		return $this->rangeEntriesEnd;
	}

	public function setRangeEntriesStart($rangeEntriesStart)
	{
		$this->rangeEntriesStart = $rangeEntriesStart;
	}

	public function getRangeEntriesStart()
	{
		return $this->rangeEntriesStart;
	}

	public function setAllListElements($allListElements)
	{
		$this->allListElements = $allListElements;
	}

	public function getAllListElements()
	{
		return $this->allListElements;
	}
}