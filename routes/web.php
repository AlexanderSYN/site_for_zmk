<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

//--------------------------------------------
// for main page
//--------------------------------------------
Route::view('/', 'main');

//--------------------------------------------
// for login
//--------------------------------------------
Route::view('/login', 'accounts.login')->middleware('guest')->name('login');

//--------------------------------------------
// for register
//--------------------------------------------
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store']);

//--------------------------------------------
// for profile
//--------------------------------------------
Route::view('/profile', 'profile.profile_main')->middleware('auth')->name('profile');


