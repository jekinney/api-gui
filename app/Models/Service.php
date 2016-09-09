<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
		'service_name',
		'enabled',
	];

	public function teams()
	{
        return $this->belongsToMany(Team::class);
	}

	public function keys()
	{
		return $this->hasMany(ServiceKey::class, 'service_id', 'service_id');
	}

	public function actions()
	{
		return $this->hasMany(ServiceAction::class, 'service_id', 'service_id');
	}
}
