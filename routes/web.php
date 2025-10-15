<?php

use App\Http\Controllers\Auth\CityAndHeroes\AddCityController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\BannedController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\HeroesVovController;
use App\Http\Controllers\HeroesSvoController;
use App\Http\Controllers\PoliticPolicyController;
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

    //
    // politic policy
    //
    Route::get('/politic_policy',[PoliticPolicyController::class, 'show'])->name('politic_policy');
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
Route::middleware('auth')->group(function() {
    // add city
    Route::get('/profile/add_city', [AddCityController::class, 'show'])->name('add_city');
    Route::post('/profile/add_city', [AddCityController::class, 'show'])->name('add_city');
    Route::get('/profile/add_city/add_city_in_BD', [AddCityController::class, 'store'])->name('add_city_in_BD');
    Route::post('/profile/add_city/add_city_in_BD', [AddCityController::class, 'store'])->name('add_city_in_BD');


    Route::get('/profile/heroes_vov', [HeroesVovController::class, 'show'])->name('heroes_vov_profile_city');
    Route::get('profile/heroes_svo', [HeroesSvoController::class, 'show'])->name('heroes_svo_profile_city');
});
