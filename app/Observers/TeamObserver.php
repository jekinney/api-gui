<?php

namespace App\Observers;

use App\Models\Team;

class TeamObserver
{
	public function creating(Team $team)
	{
        $team->slug = str_slug($team->name);
    }

    public function updating(Team $team) 
    {
        $team->slug = str_slug($team->name);
    }
}