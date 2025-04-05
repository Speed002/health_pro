<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamInviteDestroyRequest;
use App\Http\Requests\TeamInviteStoreRequest;
use App\Mail\TeamInvitation;
use App\Models\Team;
use App\Models\TeamInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TeamInviteController extends Controller
{
    public function __invoke(TeamInviteStoreRequest $request, Team $team)
    {
        $invite = $team->invites()->create([
            'email' => $request->email,
            'token' => str()->random(30)
        ]);

        // send the mail
        Mail::to($request->email)->send(new TeamInvitation($invite));

        return back()->with('toast', 'Invite sent successfully!');
    }

    public function destroy(TeamInviteDestroyRequest $request, Team $team, TeamInvite $invite){
        $invite->delete();
        return back()->with('toast', 'Invitation revoked!');
    }

    public function accept(Request $request){
        $invite = TeamInvite::where('token', $request->token)->firstOrFail();
        $request->user()->teams()->attach($invite->team);
        // set permission to team
        setPermissionsTeamId($invite->team->id);
        // assign the role of team member to user
        $request->user()->assignRole('team member');
        // set users current team to the invited team
        $request->user()->currentTeam()->associate($invite->team)->save();
        // delete invitation after accepting
        $invite->delete();
        return redirect()->route('dashboard');
    }
}
