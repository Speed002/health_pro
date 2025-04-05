<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamCreateController extends Controller
{
    public function __invoke()
    {
        return inertia()->render('Team/create');
    }
}
