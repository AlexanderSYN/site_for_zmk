<?php

//=========================================
// the controller for adding the status
// of the added hero and MP
//
// контроллер для добавления статус
// о добавленных героя и mp
//=========================================

namespace App\Http\Controllers\Auth\HeroesMPAction\moder;

use App\Models\heroes_added_by_user;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Exception;

class AddStatusActions extends Controller
{
    /**
     * redirect to add status page
     * перенаправляет на страницу добавления статуса
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

            return view('moder.add_status_for_hero_and_mp', ['user' => $user, 'hero' => $hero]);
        } catch (Exception $e) {
            return redirect()->route('profile');
        }


    }
}
