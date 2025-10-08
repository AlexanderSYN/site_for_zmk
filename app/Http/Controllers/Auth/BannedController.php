<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannedController extends Controller
{
    public function show()
    {
        // if the user has not been banned, redirect to the profile
        if (Auth::check() && !Auth::user()->isBan) {
            return redirect()->route('profile');
        }

        return view('profile.profile_banned');
    }
}

?>