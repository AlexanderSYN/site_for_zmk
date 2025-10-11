<?php

//-------------------------------------------------
// The Controller for displaying the heroes of VOV
//-------------------------------------------------

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\city_heroes_vov;


class HeroesVovController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }
        
        $heroesVov = city_heroes_vov::with('user')->get();
        
        return view('profile.heroes_vov',  compact('heroesVov'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'city' => 'required|string|max:255'
        ]);

        city_heroes_vov::create([
            'city' => $request->city,
            'user_added' => $user->first_name,
            'user_added_id' => $user->id
        ]);

        return redirect()->route('heroes_vov_profile');
    }
    
}
