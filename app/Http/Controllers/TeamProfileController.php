<?php

namespace App\Http\Controllers;


class TeamProfileController extends Controller
{
    public function __invoke()
    {
        return inertia()->render('Team/account');
    }
}
