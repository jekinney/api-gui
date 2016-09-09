<?php

namespace App\Api;

use App\Api\Base;

class ServicesActions extends Base
{
	public function dailytActionsSums()
	{
		$balance = file_get_contents($this->servicesUrl().'dailytActionsSums');
		dd($balance);
		return collect($balance);
	}

	public function dailySums()
	{
		$dailySums = file_get_contents($this->servicesUrl().'dailySums');
	}

	public function earnings()
	{
		$earnings = file_get_contents($this->servicesUrl().'earnings');
	}

	public function actionList()
	{
		$actionList = file_get_contents($this->servicesUrl().'actionList');
	}

	public function saveAction()
	{
		$saveAction = file_get_contents($this->servicesUrl().'saveAction');
	}
}