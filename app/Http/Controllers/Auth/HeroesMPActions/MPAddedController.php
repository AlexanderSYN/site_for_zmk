<?php

namespace App\Http\Controllers\Auth\HeroesMPActions;

use App\Http\Controllers\Controller;
use App\Models\mp_added_by_user;
use App\Models\city_heroes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Exception;

class MPAddedController extends Controller
{
    /**
     * 
     * redirect to added mp page
     * (перекидывание на страницу добавленных пм)
     * 
     */
    public function show(Request $request)
    {
        try {

            $user = Auth::user();

            $type = $request->input('type');
            $city = city_heroes::where('id', $request->input('city'))
                                ->first();

            if ($user->isBan) {
                return redirect()->route('profile_banned');
            }

            if ($user->role == "admin" || $user->role == "moder") {
                $memorable_places = mp_added_by_user::where('city', $city->id)
                    ->with('user','city_relation')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

                $memorable_places->appends(['user' => $user, 
                'memorable_places' => $memorable_places, 'type' => $type, 
                'city_id' => $city->id, 'city' => $city->city, 'role' => $user->role]);
            
            } 
            else if ($user->role == "user") {

                $memorable_places = mp_added_by_user::where('city', $city->id)
                    ->where('added_user_id', $user->id)
                    ->with('user','city_relation')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

                $memorable_places->appends(['user' => $user, 
                'memorable_places' => $memorable_places, 'type' => $type, 
                'city_id' => $city->id, 'city' => $city->city, 'role' => $user->role]);
            
            }
            else {
                return redirect()->route('profile');
            }
     
            return view('profile.added_heroes_city_by_user.added_mp', 
                ['user' => $user, 'memorable_places' => $memorable_places,'type' => $type,
                'city_id' => $city->id, 'city' => $city->city, 'role' => $user->role]);

        } catch (Exception $e) {
            return redirect()->route('profile');
        }
    }

    public function edit_mp_user_page(Request $request)
    {
        try {
            $user = Auth::user();

            $id = $request->input('id_mp');
            $mp = mp_added_by_user::where('id', $id)
                                    ->where('added_user_id', $user->id)
                                    ->first();

            if ($user->isBan) {
                return redirect()->route('profile_banned');
            }

            return view('profile.added_heroes_city_by_user.edit_mp', 
                    ['user' => $user, 'mp' => $mp]);
                    
        } catch (Exception $e) {
            return redirect()->route('profile');
        }

    }
}
