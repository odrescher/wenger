<?php
namespace app\controller;

use lib\ControllerAbstract;
use lib\Application;

class Praxis extends ControllerAbstract
{
	public function index()
	{
		$this->getView()->keywords = 'Osteopathie, Praxisräume, Bad Tölz, Kosten, Anfahrt';
		$this->getView()->title = 'Osteopathie Praxis Bad Tölz';
		$this->getView()->description = "Osteopathie in Bad Tölz. Verschaffen Sie sich eine Ansicht meiner Praxisräume. Planen Sie Ihre Route zu mir und erhalten Sie einen Überblick zu den Kosten";
		$this->getView()->render('praxis/index');
	}
}