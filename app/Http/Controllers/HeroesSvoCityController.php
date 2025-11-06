<?php

//-------------------------------------------------------
// The Controller for displaying the city of heroes SVO
// Контроллер для вывода городов, в котором Герои СВО
//-------------------------------------------------------

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\city_heroes;

class HeroesSvoCityController extends Controller
{
    /**
     * redirect to the heroes_svo page, where they show the cities where 
     * SVO heroes have been added
     * (перенаправить на страницу heroes_svo, где показывают города, в 
     * которых добавлены герои СВО)
     * 
     * @return profile/hereos_svo_city
     */
    public function show(Request $request)
    {
        $user = Auth::user();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        $heroesSvoCity = city_heroes::with('user')
                                    ->where('type', 'СВО')
                                    ->orderBy('city', 'desc')
                                    ->paginate(10);
        // transferring data for the following pages to paginate
        $heroesSvoCity->appends(['user' => $user, 'heroesSvo' => $heroesSvoCity]);

        $city_bd = city_heroes::where('type', 'СВО')->first();

        return view('profile.heroes_svo_city',  ['user' => $user, 
        'heroesSvo' => $heroesSvoCity, 'description_city' => $city_bd->description]);
    }
}
