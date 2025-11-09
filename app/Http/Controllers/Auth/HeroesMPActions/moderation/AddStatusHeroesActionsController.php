<?php

namespace App\Http\Controllers\Auth\HeroesMPActions\moderation;

//=========================================
// the controller for adding the status
// of the added hero and MP
//
// контроллер для добавления статус
// о добавленных героя и mp
//=========================================

use App\Models\heroes_added_by_user;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Exception;

class AddStatusHeroesActionsController extends Controller
{
    /**
     * redirect to add status page
     * (перенаправляет на страницу добавления статуса)
     */
    public function show(Request $request)
    {
        try {    
            $user = Auth::user();


            $id_hero = $request->input('id_hero');
            $hero = heroes_added_by_user::where('id', $id_hero)
                                            ->first();


            if ($user->isBan) {
                return redirect()->route('profile_banned');
            }


            return view('moderation.add_status_for_hero_and_mp', ['user' => $user, 'hero' => $hero]);


        } catch (Exception $e) {
            return redirect()->route('profile');
        }
    }

    /**
     * add the status of the hero that the user added to the database
     * (добавьте статус герою, который пользователь добавил в базу данных)
     */
    public function add_status_in_bd(Request $request) 
    {
        try {

            $id_hero = $request->input('id_hero');
            $status = $request->input('status');
            
            // updating satus (обновление статуса)
            $hero = heroes_added_by_user::where('id', $id_hero)->first();

            $hero_update = heroes_added_by_user::where('id', $id_hero)->update([
                'updated_at' => now(),
                'status' => $status
            ]);
            
            switch ($hero->type) {
                case 'ВОВ':
                    if ($hero_update)  
                        return redirect()->route('added_heroes_page_vov', ['type' => $hero->type,
                        'city' => $hero->city])
                        ->with('success', 'Статус для героя: "' . $hero->name_hero . '" успешно добавлен или изменен');
                    else
                        return redirect()->route('added_heroes_page_vov', ['type' => $hero->type,
                        'city' => $hero->city])
                        ->withErrors('Статус для героя: "' . $hero->name_hero . '" НЕ добавлен или НЕ изменен');
                    break;

                case 'СВО':
                    if ($hero_update)  
                        return redirect()->route('added_heroes_page_svo', ['type' => $hero->type,
                        'city' => $hero->city])
                        ->with('success', 'Статус для героя: "' . $hero->name_hero . '" успешно добавлен или изменен');
                    else
                        return redirect()->route('added_heroes_page_svo', ['type' => $hero->type,
                        'city' => $hero->city])
                        ->withErrors('Статус для героя: "' . $hero->name_hero . '" НЕ добавлен или НЕ изменен');
                    break;

                default:
                    return redirect()->route('profile');
                    break;    
            }

        } catch (Exception $e) {
            return redirect()->route('profile');
        }
    }
}
