<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamMemberUpdateRequest;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ChangeTeamMemberRoleController extends Controller
{
    public function __invoke(Team $team, User $user)
    {
        return inertia()->modal('Team/Member/ChangeRole', [
            'team' => $team,
            'user' => UserResource::make($user->load('roles')),
            'roles' => Role::get()
        ])->baseRoute('team.edit');
    }

    public function update(TeamMemberUpdateRequest $request, Team $team, User $user){
        // dd($request->role);
        if($request->has('role')){
            tap($team->members->find($user), function(User $member) use ($request) {
                $member->roles()->detach();
                $member->assignRole($request->role);
            });
        }
        return redirect()->route('team.edit')->with('toast', 'Role changed successfully!');
    }
}
