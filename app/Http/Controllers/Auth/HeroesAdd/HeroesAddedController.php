<?php

namespace App\Http\Controllers\Auth\HeroesAdd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\heroes_added_by_user;

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

    public function edit_hero_user(Request $request)
    {
        $user = Auth::user();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        $name_hero = $request->input('name_hero');
        $description_hero = $request->input('description_hero');
        $hero_link = $request->input('hero_link');
        $city = $request->input('city');
        $type = $request->input('type');
        $image_hero = $request->input('image_hero');
        $image_hero_qr = $request->input('image_hero_qr');

        return view('profile.added_heroes_city_by_user.edit_heroes', 
            ['user' => $user, 'name_hero' => $name_hero,
                'description_hero' => $description_hero, 'hero_link' => $hero_link,
                'image_hero' => $image_hero, 'image_hero_qr' => $image_hero_qr,
                'type' => $type, 'city' => $city]);

    }
}
