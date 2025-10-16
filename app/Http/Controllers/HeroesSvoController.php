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

        $heroesSvo = city_heroes::with('user')->get()->where('type', 'СВО');

        return view('profile.heroes_svo',  ['user' => $user, 'heroesSvo' => $heroesSvo]);
    }
}
