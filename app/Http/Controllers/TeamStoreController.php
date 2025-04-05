<?php

namespace App\Http\Controllers;

use App\Actions\CreateTeam;
use App\Http\Requests\TeamStoreRequest;
use Illuminate\Http\Request;

class TeamStoreController extends Controller
{
    public function __invoke(TeamStoreRequest $request, CreateTeam $createTeam)
    {
        $createTeam->handle($request->user(), $request->validated());
        return back();
    }

}
