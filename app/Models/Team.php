<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
    	'slug',
    	'name',
    	'description',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function members()
    {
    	return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id')->withPivot('created_at');
    }

    public function roles()
    {
    	return $this->hasMany(Role::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_team', 'team_id', 'service_id');
    }

    public function updateMembersRole($request)
    {
        $this->checkForRemoveAllTeamRoles($request)
        ->updateTeamMembersRole($request);
    }

    public function removeMember($request)
    {
        $this->find($request->team_id)->members()->detach($request->user_id);
        $this->updateMembersRole($request);
    }

    public function relationsCount()
    {
        $team = $this->load('services', 'services.keys', 'services.actions');

        $member_count = $this->collectMembers($team->members)->count();

        $services = $this->collectServices($team->services);

        $service_count = $services->count();
        $key_count = $services->pluck('keys')->flatten()->count();
        $action_count = $services->pluck('actions')->flatten()->count();

        return collect([
            'member_count' => $member_count,
            'service_count' => $service_count, 
            'key_count' => $key_count,
            'action_count' => $action_count
        ]);
    }

    protected function collectMembers($members)
    {
        return collect($members);
    }

    protected function collectServices($services)
    {
        return collect($services);
    }

    protected function checkForRemoveAllTeamRoles($request)
    {
        if($request->roles['remove']) 
        {
           User::removeMemberTeamRole($request);
           return array_add($this, 'valid', false);
        }
        return $this;
    }

    protected function updateTeamMembersRole($request)
    {
        if(!is_array($request->roles['roles']) && !$this->valid)
        {
            User::updateMemberTeamRole($request);
        }
        return $this;
    }
}
