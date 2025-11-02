<?php

namespace App\Http\Controllers\Auth\HeroesMPActions;

use App\Http\Controllers\Controller;
use App\Models\heroes_added_by_user;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        $heroes = heroes_added_by_user::where('city', $city)
                ->where('type', $type)
                ->where('city', $city)
                ->where('added_user_id', $user->id)
                ->with('user')
                ->orderBy('name_hero', 'desc')
                ->paginate(10);
        // transferring data for the following pages to paginate
        // передача данных для пагинации страниц в paginate
        $heroes->appends(['user' => $user, 'heroes' => $heroes, 'type' => $type, 'city' => $city]);

        
     
        return view('profile.added_heroes_city_by_user.added_heroes', 
            ['user' => $user, 'heroes' => $heroes,'type' => $type, 'city' => $city]);
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
