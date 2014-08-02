<?php
namespace app\controller;

use lib\ControllerAbstract;
use lib\Application;

class Uebermich extends ControllerAbstract
{
	public function index()
	{
		$this->getView()->keywords = 'Osteopathin, Masseurin, Physiotherapeutin,Kinder,Säuglinge,Sportphysiotherapeutin,Heilpraktikerin';
		$this->getView()->title = 'Osteopathie Praxis Bad Tölz | Barbara Wenger';
		$this->getView()->description = "Osteopathie in Bad Tölz. Jeder möchte etwas über seinen Osteopathen wissen. Erfahren Sie hier etwas über meinen Werdegang und meine Referenzen.";
		$this->getView()->render('kontakt/index');
	}
}