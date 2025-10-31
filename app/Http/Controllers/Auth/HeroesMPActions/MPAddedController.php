<?php

namespace App\Http\Controllers\Auth\HeroesMPActions;

use App\Http\Controllers\Controller;
use App\Models\mp_added_by_user;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MPAddedController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();

        $type = $request->input('type');
        $city = $request->input('city');

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        $memorable_places = mp_added_by_user::where('city', $city)
                ->where('city', $city)
                ->where('added_user_id', $user->id)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        $memorable_places->appends(['user' => $user, 'memorable_places' => $memorable_places, 'type' => $type, 'city' => $city]);
     
        return view('profile.added_heroes_city_by_user.added_mp', 
            ['user' => $user, 'memorable_places' => $memorable_places,'type' => $type, 'city' => $city]);
    }

    public function edit_mp_user_page(Request $request)
    {
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

    }
}
