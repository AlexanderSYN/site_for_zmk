<?php

namespace App\Http\Controllers\Auth\HeroesAdd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\show_heroes_added_by_user;

class HeroesAddedController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();

        $type = $request->input('type');
        $city = $request->input('city');

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        $heroes = show_heroes_added_by_user::with('user')->get()->where(['type' => $type, 'city' => $city]);
        
        return view('profile.added_heroes_city_by_user.added_heroes', 
        ['user' => $user, 'heroes' => $heroes,'type' => $type, 'city' => $city]);
    }
}
