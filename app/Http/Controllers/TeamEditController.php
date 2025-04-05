<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamEditController extends Controller
{
    public function __invoke(Request $request)
    {
        // $team = $request->user()->currentTeam->load('members.roles');
        // dd($team->members->map->roles);
        return inertia()->render('Team/Edit', [
            'team' => $request->user()->currentTeam->load('members.roles')
        ]);
    }
}
