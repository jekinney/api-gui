<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{   
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'for_team',
    ];

    /**
    * The attributes are cast to specific types.
    *
    * @var array
    */
    protected $casts = [
        'for_team' => 'boolean',
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
    * Many to many relationship to the Role Model.
    *
    * @var object
    */
    public function roles()
    {
    	return $this->belongsToMany(Role::class);
    }

    /**
    * Query Scopes.
    */

    /**
    * Return only Permissions for Team use.
    *
    * @var object
    */
    public function scopeForTeams($query)
    {
    	return $query->where('for_team', 1);
    }

    /**
    * Return only Permissions for site Developer (non-teams) use.
    *
    * @var object
    */
    public function scopeForDevelopers($query)
    {
    	return $query->where('for_team', 0);
    }
}
