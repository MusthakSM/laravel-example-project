<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    // method create to create a registered user..
    public function create(){
        return view('auth.register');
    }

    public function store(){
        // validate inputs..
        $validatedAttributes = request()->validate([
            'first_name' => ['required'],
            'last_name'  => ['required'],
            'email'      => ['required', 'email'],
            'password'   => ['required', Password::min(6), 'confirmed']
        ]);

        // create the user..
        $user = User::create($validatedAttributes);

        // login
        Auth::login($user);

        // redirect to somewhere..
        return redirect('/jobs');
    }
}
