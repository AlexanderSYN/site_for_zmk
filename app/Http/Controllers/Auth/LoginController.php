<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\Messages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //--------------------------------------------
    //returns the page with the login form
    //--------------------------------------------
    public function create()
    {
        return view('accounts.login');
    }

    //--------------------------------------------
    // Processing a new user, validating and saving
    // in a database
    //--------------------------------------------
    public function store(Request $request)
    {
        
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Неверный ЛОГИН или ПАРОЛЬ!'
                ]);
        }

        return redirect()->route('profile');
    }
    
    //
    //
    //
    public function destroy(Request $request)
    {
        Auth::logout();

        return redirect()->route('main');
    }
}
