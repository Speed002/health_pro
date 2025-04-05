<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetCurrentTeamRequest;
use App\Models\Team;

class TeamSwitchController extends Controller
{
    public function __invoke(SetCurrentTeamRequest $request, Team $team){
        // triggering policy before changing hospital
        // Gate::authorize('setCurrent', $hospital); //we prefer using requests though like in the brackets
        $request->user()->currentTeam()->associate($team->load('users'))->save();
        return back()->with('toast', 'Hospital switched successfully');
    }
}
