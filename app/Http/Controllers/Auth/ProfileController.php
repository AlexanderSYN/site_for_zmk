<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show()
    {        
        $user = Auth::user();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }
    
        return view('profile.profile', ['user' => $user]);
    }

    public function change_data($id, $first_name, $last_name, $patronymic, $login, $email)
    {
        DB::update(
            'update users set first_name = ? and last_name = ? and patronymic = ?
            and login = ? and email = ?',
            [$first_name, $last_name, $patronymic, $login, $email]
        );

        return view('profile.profile');
    }
}

?>