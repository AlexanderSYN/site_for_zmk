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
        
        $heroesVov = city_heroes::with('user')->get()->where('type', 'ВОВ');
        
        return view('profile.heroes_vov',  compact('heroesVov'));
    }
    
}
