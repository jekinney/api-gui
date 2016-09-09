<?php

namespace App\Api;

abstract class Base
{	
	public $userId;

	public function __construct($userId)
	{
		$this->userId = $userId;
	}

	protected function rewardsUrl()
	{
		return env('REWARDS_URL').'/v1.1/rewards/'.$this->userId.'/';
	}

	protected function servicesUrl()
	{
		return env('SERVICE_URL').'/v1.1/service/'.$this->userId.'/';
	}
}