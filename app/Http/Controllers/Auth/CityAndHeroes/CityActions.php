<?php

namespace App\Http\Controllers\Auth\CityAndHeroes;

use App\Http\Controllers\Controller;
use App\Models\city_heroes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Exception;

class CityActions extends Controller
{
    /**
     * redirect to the edit_info_about_city page
     * (перекидывает на страницу изменения информации о городе)
     * 
     * @return role, id_city, all data about city from base date (role, id_city, всю информацию о городе из базы данных)
     */
    public function show(Request $request)
    {
        try {
            $id = $request->input('id_city');
            $user = Auth::user();

            $city_bd = city_heroes::where('id', $id)->first();

            return view('profile.added_heroes_city_by_user.edit_info_about_city', 
                    ['role' => $user->role, 'id_city' => $id, 'city' => $city_bd]);
        } catch (Exception $e) {
            return redirect()->route('profile');
        }
    } 

    /**
     * redirect to the heroes vov or svo or memorable places city
     * (перекидывает на страницу герои вов или сво или памятные места city)
     */
    public function edit_city_user(Request $request)
    {
        //==============================
        // getting city data
        // получитение данных о городе
        //==============================
        try {
            $id = $request->input('id_city');
            $city = city_heroes::where('id', $id)->get()->first();
        } catch (Exception $e) {
            return redirect()->route('heroes_vov_profile_city')
                                ->withErrors('Не удалось получить данные о городн!');
        }

        //==================================
        // updating city data in bd
        // обновление данных о городе в бд
        //==================================
        try {
            $name_city = $request->input('name_city') == null ? $city->city : $request->input('name_city');
            $description = $request->input('description_city');

            // update data about city in bd
            // обновить данные о городе в бд
            $city->update([
                'updated-at' => now(),
                'city' => $name_city,
                'description' => $description
            ]);

            // comeback
            // возвращение
           switch ($city->type) {
                case "ВОВ":
                    return redirect()->route('heroes_vov_profile_city')
                            ->with('success', 'Данные города: "'. $city->city . '" успешно изменены!');
                    break;
                    
                
                case "СВО":
                    return redirect()->route('heroes_svo_profile_city')
                            ->with('success', 'Данные города: "'. $city->city . '" успешно изменены!');
                    break;
                
                case "ПМ":
                    return redirect()->route('mp_profile_city')
                            ->with('success', 'Данные города: "'. $city->city . '" успешно изменены!');
                    break;
            }

        } catch (Exception $e) {
            switch ($city->type) {
                case "ВОВ":
                    return redirect()->route('heroes_vov_profile_city')
                            ->withErrors('Не удалось изменить данные города:"' . $city->city . '"!');
                    break;
                    
                
                case "СВО":
                    return redirect()->route('heroes_svo_profile_city')
                            ->withErrors('Не удалось изменить данные города:"' . $city->city . '"!');
                    break;
                
                case "ПМ":
                    return redirect()->route('mp_profile_city')
                            ->withErrors('Не удалось изменить данные города:"' . $city->city . '"!');
                    break;
            }
        }

    }
}
