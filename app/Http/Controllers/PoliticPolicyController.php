<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoliticPolicyController extends Controller
{
    public function show()
    {
        return view('accounts.politic_policy');
    }
}
