<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\city_heroes;

class HeroesSvoController extends Controller
{
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

        return view('profile.heroes_svo_city',  ['user' => $user, 'heroesSvo' => $heroesSvoCity]);
    }
}
