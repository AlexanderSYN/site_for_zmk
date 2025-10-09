<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function change_data(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'login' => 'required|string|max:255|unique:users,login,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }  

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'patronymic' => $request->patronymic,
                'login' => $request->login,
                'email' => $request->email,
                'updated_at' => now()
            ]);

        return redirect()->route('profile')
            ->with('success', 'Данные профиля успешно обновлены!');
    }
}

?>