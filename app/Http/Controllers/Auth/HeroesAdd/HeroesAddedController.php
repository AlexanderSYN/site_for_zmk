<?php

namespace App\Http\Controllers\Auth\HeroesAdd;

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
                ->orderBy('created_at', 'desc')
                ->paginate(10);
     
        return view('profile.added_heroes_city_by_user.added_heroes', 
            ['user' => $user, 'heroes' => $heroes,'type' => $type, 'city' => $city]);
    }

    public function edit_hero_user_page(Request $request)
    {
        $user = Auth::user();

        $id = $request->input('id_hero');

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        $hero = heroes_added_by_user::where('id', $id)->with('user')->first();

        return view('profile.added_heroes_city_by_user.edit_heroes', 
                ['user' => $user, 'hero' => $hero ]);

    }

    public function edit_hero_user(Request $request)
    {
        $user = Auth::user();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        $id = $request->input('id_hero');

        $name_hero = $request->input('name_hero');
        $description_hero = $request->input('description');
        
        $hero_link = $request->input('hero_link');
        $image_hero = $request->input('image_hero');
        $image_hero_qr = $request->input('image_hero_qr');

        $hero = heroes_added_by_user::where('id', $id)->with('user')->first();

        heroes_added_by_user::where('id', $id)
            ->update(array(
                'name_hero' => $name_hero,
                'description_hero' => $description_hero,
                'hero_link' => $hero_link,
                'image_hero' => $image_hero,
                'image_qr' => $image_hero_qr,
                'isCheck' => false
            ));

        return view('profile.added_heroes_city_by_user.edit_heroes', 
                ['user' => $user, 'hero' => $hero ])
            ->with('success', 'Данные героя успешно обновлены!');
    }
}
