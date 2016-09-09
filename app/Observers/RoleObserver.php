<?php

namespace App\Observers;


class RoleObserver
{
	public function creating(Role $role)
	{
		$role->slug = str_slug($role->name);
	}

	public function updating(Role $role)
	{
		$role->slug = str_slug($role->name);
	}

	public function deleting(Role $role)
	{
		$role->permissions()->detach();
        $role->users()->detach();
	}
}