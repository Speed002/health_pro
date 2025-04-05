<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamLeaveRequest;
use App\Models\Team;

class TeamLeaveController extends Controller
{
    public function __invoke(TeamLeaveRequest $request, Team $team)
    {
        $user = $request->user();
        $user->teams()->detach($team);

        // set current team to another team
        $user->currentTeam()->associate($user->fresh()->teams()->first())->save();
        // detach user from any roles too
        $user->roles()->detach();

        return redirect()->route('dashboard');
    }
}
