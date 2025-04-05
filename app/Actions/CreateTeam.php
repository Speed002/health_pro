<?php

namespace App\Actions;

use App\Models\Team;
use App\Models\User;

class CreateTeam
{
    public function handle(User $user, array $data){
        $user->teams()->attach(
            $team = Team::create($data)
        );
        // using the relationship in the user model and ssociating it with the current team being created... common english
        $user->currentTeam()->associate($team);
        $user->save();

        // assigning a user a role under a specific team Id
        setPermissionsTeamId($team->id);
        $user->assignRole('team admin');
    }
}
