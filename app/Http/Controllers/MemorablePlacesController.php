<?php

//-----------------------------------------------------
// The Controller for displaying the Memorable Places
//-----------------------------------------------------

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\city_heroes;

class MemorablePlacesController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        $memorable_places = city_heroes::with('user')->get()->where('type', 'ПМ'); // ПМ - Памятные Места (Memorable places)

        return view('profile.memorable_places',  ['user' => $user, 'memorable_places' => $memorable_places]);
    }
}
