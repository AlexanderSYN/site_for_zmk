<?php

use App\Http\Controllers\Auth\LoginController;
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
Route::get('/login', [LoginController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');

//--------------------------------------------
// for register
//--------------------------------------------
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store']);

//--------------------------------------------
// for profile
//--------------------------------------------
Route::view('/profile', 'profile.profile_main')->middleware('auth')->name('profile');


