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
    // returns the page with the login form
    // (возвращаем страницу входы в аккаунт)
    //--------------------------------------------
    public function create()
    {
        return view('accounts.login');
    }

    //--------------------------------------------
    // Processing a new user, validating and saving
    // in a database
    // (Обработка нового пользователя, проверка 
    // подлинности и сохранение в базе данных)
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

        
        $user = Auth::user();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        switch ($user->role) {
            case "moder":
                // redirect to moder
                break;
            case "admin":
                // redirect to admin
                break;
            default:
                return redirect()->route('profile');
        }
       

        return redirect()->route('profile');
    }
    
    //
    // logout from accounts
    // (выход из аккаунта)
    //
    public function destroy(Request $request)
    {
        Auth::logout();

        return redirect()->route('main');
    }
}
