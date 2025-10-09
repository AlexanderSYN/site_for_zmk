<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\BannedController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\UserController;

//--------------------------------------------
// for main page
//--------------------------------------------
Route::view('/', 'main')->name('main');

//--------------------------------------------
// Routes for guests
//--------------------------------------------
Route::middleware('guest')->group(function () {
    //--------------------------------------------
    // for login and logout
    //--------------------------------------------
    Route::get('/login', [LoginController::class, 'create'])->middleware('guest')->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('guest');
    
    //--------------------------------------------
    // for register
    //--------------------------------------------
    Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::get('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

//----------------------------------------------------
// Routes for authorized users with ban verification
//----------------------------------------------------
Route::middleware(['auth'])->group(function() {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

});

//----------------------------------------------------
// Route for banned users (available even if banned)
//----------------------------------------------------
Route::get('/profile/banned', [BannedController::class, 'show'])
    ->middleware('auth')
    ->name('profile_banned');

//----------------------------------------------------
// change data profiles
//----------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile/change-data', [ProfileController::class, 'change_data'])->name('change_data');
});

//--------------------------------------------
// for add heroes and memory places
//--------------------------------------------
//--------------------------------------------
// add heroe
//--------------------------------------------
Route::get('/add_heroe', [])->middleware('auth')->name('add_heroe');
