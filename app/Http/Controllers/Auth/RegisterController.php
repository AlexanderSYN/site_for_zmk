<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class RegisterController extends Controller
{
    //--------------------------------------------
    //returns the page with the registration form
    //--------------------------------------------
    public function create()
    {
        return view('accounts.register');
    }

    //--------------------------------------------
    // Processing a new user, validating and saving
    // in a database
    //--------------------------------------------
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'login' => $request->login,
            'password' => $request->password
        ]);

        Auth::login($user);

        return redirect()->route('profile');
    }
}
