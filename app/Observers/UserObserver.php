<?php

namespace App\Observers;

use App\Actions\CreateTeam;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class UserObserver
{

    public function __construct(protected CreateTeam $createTeam)
    {

    }

    public function created(User $user){
        $this->createTeam->handle($user, [
            'name' => $user->name
        ]);
    }

    public function deleting(User $user){
        // detach user from team before deleting the user
        $user->teams()->detach();
    }
}
