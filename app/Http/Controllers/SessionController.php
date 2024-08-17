<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    // method/ action to create a session
    public function create(){
        return View('auth.login');
    }

    public function store(){
        // validate the user
        $validatedCredentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(6)]
        ]);

        // attempt to login the user (or) check the credential matches..
        if(!Auth::attempt($validatedCredentials)){
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match!.'
            ]);
        }

        //  regenerate the session token
        request()->session()->regenerate();

        // redirect the user to somewhere..
        return redirect('/jobs');
    }

    public function destroy(){
        // Logout the user
        Auth::logout();

        // Redirect them to Home page..
        return redirect('/');
    }
}
