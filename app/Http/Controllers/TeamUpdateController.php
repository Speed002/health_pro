<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamUpdateRequest;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamUpdateController extends Controller
{
    public function __invoke(TeamUpdateRequest $request, Team $team)
    {
        $team->update($request->only('name'));
        return back()->with('toast', 'Updated successfully!');
    }
}
