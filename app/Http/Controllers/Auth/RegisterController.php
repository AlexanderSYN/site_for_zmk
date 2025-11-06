<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Controllers\Auth\HeroesMPActions\helper\Helper_register;

use App\Helpers\Messages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Exception;

class RegisterController extends Controller
{
    //-----------------------------------------------
    // returns the page with the registration form
    // (возвращает страницу с формой регистрации)
    //-----------------------------------------------
    public function create()
    {
        return view('accounts.register');
    }

    //----------------------------------------------
    // Processing a new user, validating and saving
    // in a database
    // (Обработка нового пользователя, проверка 
    // подлинности и сохранение в базе данных)
    //---------------------------------------------
    public function store(Request $request)
    {

        $name = $request->input('name');

        //--------------------------------------------
        // get first, last name and patronymic
        // (получение имени, фамилии и отчества)
        //--------------------------------------------
        $get_full_name = explode(" ", $name);

        $first_name = Helper_register::get_current_first_name($get_full_name);
        $last_name = $get_full_name[0];
        $patronymic = Helper_register::get_current_patronymic($get_full_name);

            
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'login' => 'required|string|unique:users|max:255',
            'password' => 'required|min:8'
        ]);

        try {
            $user = User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'patronymic' => $patronymic,
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
