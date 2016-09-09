<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    	'team_id',
    	'leader_role',
    	'slug',
    	'name',
    	'description',
        'deleteable',
    ];

    /**
    * The attributes are cast to specific types.
    *
    * @var array
    */
    protected $casts = [
    	'leader_role' => 'boolean',
        'deleteable' => 'boolean',
    ];

    /**
    * The route key name for route model binding.
    *
    * @var string
    */
    public function getRouteKeyName()
	{
	    return 'slug';
	}

    /**
    * Eloquent Relationships
    */
    /**
    * Many to many relationship to the User Model.
    *
    * @var object
    */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
    * Many to many relationship to the Permission Model.
    *
    * @var object
    */
    public function permissions()
    {
    	return $this->belongsToMany(Permission::class);
    }

    /**
    * One to Many relationship to the Team Model.
    *
    * @var object
    */
    public function team()
    {
    	return $this->belongsTo(Team::class);
    }

    /**
    * Query Scopes.
    */

    /**
    * Return only Roles that are assigned to a Team.
    *
    * @var object
    */
    public function scopeTeamsOnly($query)
    {
        return $query->where('team_id', '>', 0);
    }

    /**
    * Return only Roles that are for the site admins.
    *
    * @var object
    */
    public function scopeAdminsOnly($query)
    {
        return $query->where('team_id', 0)->where('leader_role', 0);
    }

    /**
    * Helper methods.
    *
    * @var object
    */

    /**
    * Create a new Role and sync permissions.
    *
    * @var object
    */
    public function createRequest($request)
    {
        $this->create($request->all())->syncPermissions($request->permissions);
        return $this;
    }

    /**
    * Update a current Role and sync permissions.
    *
    * @var object
    */
    public function updateRequest($request)
    {
        $this->find($request->id)->syncPermissions($request->permissions)->update($request->all());
        return $this;
    }

    /**
    * Remove a Role. RoleObserver will detach permissions assigned to the Role.
    *
    * @var object
    */
    public function remove($request)
    {
        $this->find($request->id)->delete();
    }

    /**
    * Protected helper function to sync permissions on a Role Instance.
    *
    * @var object
    */
    protected function syncPermissions($permissions)
    {
        $this->permissions()->sync($permissions);
        return $this;
    }
}
