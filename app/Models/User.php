<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    * The route key name for route model binding.
    *
    * @var string
    */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
    * Set Attribute to hash all passwords coming into the database.
    */
    public function setPasswordAttribute($password)
    {
        return $this->attributes['password'] = bcrypt($password);
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
    * Many to many relationship to the Role Model filtered for Roles with a team id.
    *
    * @var object
    */
    public function teamRoles() 
    {
        return $this->belongsToMany(Role::class)->where('team_id', '<>', 0);
    }

    /**
    * Many to many relationship to the Team Model with loading pivot table timestamps.
    *
    * @var object
    */
    public function teams()
    {
        return $this->belongsToMany(Team::class)->withTimestamps();
    }

    public static function removeMemberTeamRole($request)
    {
        self::find($request->user_id)->roles()->detach($request->roles['roles']);
    }

    public static function updateMemberTeamRole($request)
    {
        $user = self::find($request->user_id);
        foreach($user->teamRoles as $role)
        {
            $user->roles()->detach($role->id);
        }
        $user->roles()->attach($request->roles['roles']);
    } 
}
