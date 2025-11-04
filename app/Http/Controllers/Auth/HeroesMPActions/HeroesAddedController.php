<?php

namespace App\Http\Controllers\Auth\HeroesMPActions;

use App\Http\Controllers\Controller;
use App\Models\heroes_added_by_user;
use App\Models\city_heroes;

use App\Http\Controllers\Auth\HeroesMPActions\helper\Helper_hero;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HeroesAddedController extends Controller
{
    //===========================
    // for user and showing heroes
    // для пользователей
    // показываем героев
    //============================
    public function show(Request $request)
    {
        $user = Auth::user();

        $type = $request->input('type');
        $city = city_heroes::where('id', $request->input('city'))
                            ->where('type', $type)
                            ->first();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        $heroes = Helper_hero::get_current_url_for_added_heroes($user->role, $city, $type, $user->id);

        // transferring data for the following pages to paginate
        // передача данных для пагинации страниц в paginate
        $heroes->appends(['user' => $user, 'heroes' => $heroes, 'type' => $type, 'city' => $city->city, 'role' => $user->role]);

        return view('profile.added_heroes_city_by_user.added_heroes', 
            ['user' => $user, 'heroes' => $heroes, 'type' => $type, 'city' => $city->city,
            'role' => $user->role]);
    }

    public function edit_hero_user_page(Request $request)
    {
        $user = Auth::user();

        $id = $request->input('id_hero');
        $hero = heroes_added_by_user::where('id', $id)
                                ->where('added_user_id', $user->id)
                                ->first();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        return view('profile.added_heroes_city_by_user.edit_heroes', 
                ['user' => $user, 'hero' => $hero ]);
    }

}
