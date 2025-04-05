<?php

namespace App\Http\Controllers;

use App\Http\Requests\RemoveTeamMemberRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class RemoveTeamMemberController extends Controller
{
    public function __invoke(RemoveTeamMemberRequest $request, Team $team, User $user)
    {
        $team->members()->detach($user);
        // associate user with a team in their list
        $user->currentTeam()->associate($user->teams()->first())->save();
        return redirect()->route('team.edit')->with('toast', 'Member removed successfully');
    }
}
