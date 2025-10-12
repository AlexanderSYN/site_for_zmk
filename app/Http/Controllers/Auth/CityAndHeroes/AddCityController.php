<?php

namespace App\Http\Controllers\Auth\CityAndHeroes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddCityController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        return view('profile.add_hero_and_city.add_city', ['user' => $user]);
    }

    
}
