<?php

namespace App\Http\Controllers\Auth\CityAndHeroes;

use App\Http\Controllers\Controller;
use App\Models\city_heroes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class AddCityController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $city = $request->input('name_hero');

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        if ($city == "ВОВ") {
            return view('profile.add_hero_and_city.add_city_vov', ['user' => $user, 'city' => $city]);
        } 
        else if ($city == "СВО") {
            return view('profile.add_hero_and_city.add_city_svo', ['user' => $user, 'city' => $city]);
        }

        return view('profile.profile', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $user_selected_content = $request->input('content');
        $city = $request->input('city');
        $description = $request->input('description');

        try {
            $validator = Validator::make($request->all(), [
                'content' => 'required|string|max:255',
                'description' => 'required|string|max:500'
            ]);

            if ($user->isBan) {
                return redirect()->route('profile_banned');
            }

            $existingCity = city_heroes::where('city', $city)
                    ->where('type', $user_selected_content)
                    ->first();

            if ($existingCity) {
                return redirect()->back()
                        ->withErrors('Такой Город Уже Существует!')
                        ->withInput();
            }

            $data = city_heroes::create([
                'city' => $request->city,
                'description' => $request->description,
                'type' => $user_selected_content,
                'added_user_id' => $user->id,
                'added_user_name' => $user->first_name
            ]);

            if ($user_selected_content == "ВОВ")
            {
                return redirect()->route('heroes_vov_profile_city');
            }
            else if ($user_selected_content == "СВО")
            {
                return redirect()->route('heroes_vov_profile_city');
            }
            else 
            {
                return redirect()->route('profile');
            }
            

        } catch (Exception $e) {
             return redirect()->back()
                    ->withErrors("Неизвестная Ошибка!")
                    ->withInput();
        
        }
        
    } 

    
}
