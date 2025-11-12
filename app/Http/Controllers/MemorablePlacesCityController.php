<?php

//----------------------------------------------------------
// The Controller for displaying the Memorable Places
// Контроллер для вывода городов, в котором Памятные Места
//----------------------------------------------------------

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\city_heroes;

use Exception;

class MemorablePlacesCityController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        $memorable_places = city_heroes::with('user')
                                    ->where('type', 'ПМ')
                                    ->orderBy('city', 'desc')
                                    ->paginate(10); // ПМ - Памятные Места (Memorable places)
        // transferring data for the following pages to paginate
        $memorable_places->appends(['user' => $user, 'memorable_places' => $memorable_places]);

        return view('profile.memorable_places_city',  ['user' => $user, 
        'memorablePlaceCity' => $memorable_places]);
    }

}
