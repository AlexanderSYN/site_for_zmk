<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\Messages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Exception;

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
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'login' => 'required|string|unique:users|max:255',
            'password' => 'required|confirmed|min:8'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'login' => $validated['login'],
            'password' => Hash::make($validated['password'])
        ]);

        Auth::login($user);

        return redirect()->route('profile');
    } 
}
