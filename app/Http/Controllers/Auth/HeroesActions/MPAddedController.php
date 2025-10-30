<?php

namespace App\Http\Controllers\Auth\HeroesActions;

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
                ->where('type', $type)
                ->where('city', $city)
                ->where('added_user_id', $user->id)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        $memorable_places->appends(['user' => $user, 'memorable_places' => $memorable_places, 'type' => $type, 'city' => $city]);
     
        return view('profile.added_heroes_city_by_user.added_mp', 
            ['user' => $user, 'memorable_places' => $memorable_places,'type' => $type, 'city' => $city]);
    }
}
