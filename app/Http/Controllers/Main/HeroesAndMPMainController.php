<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\city_heroes;
use App\Models\heroes_added_by_user;

//=========================================
// A controller for showing all the 
// verified vov heroes, which can be 
// viewed even by unregistered users.
// (Контроллер для показа всех 
// проверенных героев VOV, которые смогут
// увидеть даже не зарегестрированные 
// пользователи)
//=========================================

class HeroesAndMPMainController extends Controller
{
    // redirect to the choice a city page
    // (перекинуть на страницу выбора города)
    public function show_city_heroes_vov()
    {
        $heroesVovCity = city_heroes::where('type', 'ВОВ')
                        ->orderBy('city', 'desc')
                        ->paginate(10);
        // transferring data for the following pages to paginate
        // передача данных для пагинации страниц в paginate
        $heroesVovCity->appends(['heroesVovCity' => $heroesVovCity]);

        return view('main.city.heroes_vov_city_main', ['heroesVovCity' => $heroesVovCity]);
    }

    // show all heroes VOV where isCheck = true
    // показать всех героев ВОВ где isCheck = true
    public function show_heroes_vov(Request $request)
    {
        $city = $request->input('city');

        $heroesVov = heroes_added_by_user::where('type', 'ВОВ')
                                        ->where('city', $city)
                                        ->where('isCheck', 1)
                                        ->paginate(10);
        $heroesVov->appends(['heroes_vov' => $heroesVov, 'type' => 'ВОВ', 'city' => $city]);

        return view('main.heroes_and_mp.heroes_vov_main', ['heroes_vov' => $heroesVov, 'type' => 'ВОВ', 'city' => $city]);
    }
}
