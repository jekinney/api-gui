<?php

namespace App\Observers;

use App\Models\Permission;

class PermissionObserver
{
	public function creating(Permission $permission)
	{
		$permission->slug = str_slug($permission->name);
	}

	public function updating(Permission $permission)
	{
		$permission->slug = str_slug($permission->name);
	}
}