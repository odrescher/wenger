<?php
namespace app\controller;

use lib\ControllerAbstract;
use lib\Application;

class Therapie extends ControllerAbstract
{
	public function index()
	{
		$this->getView()->keywords = 'Osteopathie, craniosacrale Osteopathie, viszerale Osteopathie, parietale Osteopathie, Skelett, Muskeln, Organe';
		$this->getView()->title = 'Osteopathie Praxis Bad Tölz | Therapieformen';
		$this->getView()->description = "Osteopathie - Integrative Körperarbeit - Sportphysiotherapie in Bad Tölz. Ich erkläre welche Behandlungsform der Osteopathie für Sie am besten geeignet ist.";
		$this->getView()->render('therapie/index');
	}
}