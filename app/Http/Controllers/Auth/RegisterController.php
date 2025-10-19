<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\Messages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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

        $name = $request->input('name');

        //--------------------------------------------
        // get first, last name and patronymic
        //--------------------------------------------
        $get_full_name = explode(" ", $name);

            
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'login' => 'required|string|unique:users|max:255',
            'password' => 'required|min:8'
        ]);

        try {
            $user = User::create([
                'first_name' => $get_full_name[0],
                'last_name' => $get_full_name[1],
                'patronymic' => $get_full_name[2],
                'email' => Crypt::encrypt($validated['email']),
                'login' => $validated['login'],
                'password' => Hash::make($validated['password'])
            ]);
        } catch (Exception $e) {
            if ($e->getMessage() == "Undefined array key 1" ||
                $e->getMessage() == "Undefined array key 2") {
                   return back()
                        ->withInput()
                        ->withErrors([
                        'error' => 'ВЫ ВВЕЛИ НЕПОЛНЫЕ ДАННЫЕ (В ПОЛЕ ФИО)!'
                ]);   
            }
            return back()
                ->withInput()
                ->withErrors([
                'error' => 'НЕИЗВЕСТНАЯ ОШИБКА!'
            ]);
        }

        Auth::login($user);
       
        return redirect()->route('profile');
    } 
}
