<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    public function setCurrent(User $user, Team $team){
        // checking the user hospitals to ensure the current hospital exists in that list
        return $user->teams->contains($team);
    }

    public function update(User $user, Team $team){
        if(!$user->teams->contains($team)){
            return false;
        }
        return $user->can('update team');
    }

    public function leave(User $user, Team $team){
        if(!$user->teams->contains($team)){
            return false;
        }
        return $user->teams->count() != 1; //will go through if it is not only one team remaining that you are part of
    }

    public function removeTeamMember(User $user, Team $team, User $member){
        if($user->id === $member->id){
            return false;
        }
        if($team->members->doesntContain($member)){
            return false;
        }
        return $user->can('remove team members'); //this is a permission
    }

    public function inviteToTeam(User $user, Team $team){
        if($user->teams->doesntContain($team)){
            return false;
        }
        return $user->can('invite to team');
    }

    public function revokeInvite(User $user, Team $team){
        return $user->can('revoke invitation');
    }

    public function changeMemberRole(User $user, Team $team, User $member){
        if($team->members->doesntContain($member)){
            return false;
        }
        return $user->can('change member roles');
    }
}
