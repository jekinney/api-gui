<?php

namespace App\Traits;

trait UserModel 
{
	public function hasRole($slug, $requireAll = false)
	{
		if (is_array($slug)) {
            foreach ($slug as $roleName) {
                $hasRole = $this->hasRole($roleName);
                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }
            // If we've made it this far and $requireAll is FALSE, then NONE of the roles were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the roles were found.
            // Return the value of $requireAll;
            return $requireAll;
        } else {
            foreach ($this->roles as $role) {
                if ($role->slug == $slug) {
                    return true;
                }
            }
        }
        return false;
	}

	/**
     * Check if user has a permission by its slug.
     *
     * @param string|array $permission Permission string or array of permissions.
     * @param bool         $requireAll All permissions in the array are required.
     *
     * @return bool
     */
    public function can($slug, $requireAll = false)
    {
        if (is_array($slug)) {
            foreach ($slug as $permSlug) {
                $hasPerm = $this->can($permSlug);
                if ($hasPerm && !$requireAll) {
                    return true;
                } elseif (!$hasPerm && $requireAll) {
                    return false;
                }
            }
            // If we've made it this far and $requireAll is FALSE, then NONE of the perms were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
            // Return the value of $requireAll;
            return $requireAll;
        } else {
            foreach ($this->roles as $role) {
                // Validate against the Permission table
                foreach ($role->permissions as $perm) {
                    if ($perm->slug == $slug) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Check if user has a permission by its slug.
     *
     * @param string|array $permission Permission string or array of permissions.
     * @param bool         $requireAll All permissions in the array are required.
     *
     * @return bool
     */
    public function canForTeam($slug, $teamId, $requireAll = false)
    {
        if (is_array($slug)) {
            foreach ($slug as $permSlug) {
                $hasPerm = $this->can($permSlug);
                if ($hasPerm && !$requireAll) {
                    return true;
                } elseif (!$hasPerm && $requireAll) {
                    return false;
                }
            }
            // If we've made it this far and $requireAll is FALSE, then NONE of the perms were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
            // Return the value of $requireAll;
            return $requireAll;
        } else {
            foreach ($this->roles->where('team_id', $teamId) as $role) {
                // Validate against the Permission table
                foreach ($role->permissions as $perm) {
                    if ($perm->slug == $slug) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}