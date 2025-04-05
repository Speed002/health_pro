<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke()
    {
        // dd(auth()->user()->hasRole('team admin')); //checking the functionality of the role
        return inertia()->render('Dashboard');
    }

}
