<?php

//-------------------------------------------------------
// The Controller for displaying the city of heroes VOV
// Контроллер для вывода городов, в котором Герои ВОВ
//-------------------------------------------------------

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\city_heroes;

use Exception;

class HeroesVovCityController extends Controller
{
    /**
     * redirect to the heroes_vov page, where they show the cities where 
     * VOV heroes have been added
     * (перенаправить на страницу heroes_vov, где показывают города, в 
     * которых добавлены герои ВОВ)
     * 
     * @return profile/hereos_vov_city
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }
        
        $heroesVovCity = city_heroes::with('user')
                                    ->where('type', 'ВОВ')
                                    ->orderBy('city', 'desc')
                                    ->paginate(10);
        // transferring data for the following pages to paginate
        $heroesVovCity->appends(['user' => $user, 'heroesVovCity' => $heroesVovCity]);

        $city_bd = city_heroes::where('type', 'ВОВ')->first();

        return view('profile.heroes_vov_city',  ['user' => $user, 
        'heroesVovCity' => $heroesVovCity, 'id_city' => $heroesVovCity]);
    }
    

}
