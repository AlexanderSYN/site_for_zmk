<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

//--------------------------------------------
// for main page
//--------------------------------------------
Route::view('/', 'main')->name('main');

//--------------------------------------------
// for login
// and logout
//--------------------------------------------
Route::get('/login', [LoginController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');

Route::get('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

//--------------------------------------------
// for register
//--------------------------------------------
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store']);

//--------------------------------------------
// for profile
//--------------------------------------------
Route::view('/profile', 'profile.profile_main')->middleware('auth')->name('profile');


//--------------------------------------------
// for add heroes and memory places
//--------------------------------------------

//--------------------------------------------
// add heroe
//--------------------------------------------
Route::get('/add_heroe', [])->middleware('auth')->name('add_heroe');
