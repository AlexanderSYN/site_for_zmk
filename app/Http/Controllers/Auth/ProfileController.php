<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        
        $user = Auth::user();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }
    
        return view('profile.profile', ['user' => $user]);
    }
}

?>