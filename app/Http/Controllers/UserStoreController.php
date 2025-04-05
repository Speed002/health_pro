<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserStoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            // make these seeable in fillables so that they can be filled when creating a hospital
            'contact' => 123123,
            'email_verified_at' => now()
        ]);

        return back()->with('toast', 'Hospital created successfully!');
    }
}
