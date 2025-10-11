<?php

//-------------------------------------------------
// The Controller for displaying the heroes of VOV
//-------------------------------------------------

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\


class HeroesVovController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        return view('profile.heroes_vov');
    }

    
}
