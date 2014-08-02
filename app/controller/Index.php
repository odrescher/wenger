<?php
namespace app\controller;

use lib\ControllerAbstract;
use lib\Application;

class Index extends ControllerAbstract
{
	public function index()
	{
		$this->getView()->render('index');
	}

	public function impressum()
	{
		$this->getView()->keywords = 'Osteopathie, Kontakt, Berufshaftplficht, Bildnachweis, Haftung';
		$this->getView()->title = 'Osteopathie Praxis Bad Tölz | Impressum';
		$this->getView()->description = "Osteopathie - Integrative Körperarbeit - Sportphysiotherapie in Bad Tölz. Im Impressum erhalten Sie alle Informationen zum Betreiber der Webseite.";
		$this->getView()->render('impressum');
	}

}