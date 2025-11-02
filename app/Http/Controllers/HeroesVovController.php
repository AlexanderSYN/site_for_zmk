<?php

//-------------------------------------------------
// The Controller for displaying the heroes of VOV
//-------------------------------------------------

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\city_heroes;

class HeroesVovController extends Controller
{
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

        return view('profile.heroes_vov_city',  ['user' => $user, 'heroesVovCity' => $heroesVovCity]);
    }
    
}
