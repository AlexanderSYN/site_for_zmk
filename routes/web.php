<?php

use App\Http\Controllers\Auth\CityAndHeroes\AddCityController;
use App\Http\Controllers\Auth\HeroesAdd\HeroesAddedController;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\BannedController;
use App\Http\Controllers\Auth\HeroesAdd\HeroesAddController;
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

    //--------------------------------------------
    // politic policy
    //--------------------------------------------
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
    //--------------------------------------------
    // add city
    //--------------------------------------------
    Route::get('/profile/add_city', [AddCityController::class, 'show'])->name('add_city');
    Route::post('/profile/add_city', [AddCityController::class, 'show'])->name('add_city');
    Route::get('/profile/add_city/add_city_in_BD', [AddCityController::class, 'store'])->name('add_city_in_BD');
    Route::post('/profile/add_city/add_city_in_BD', [AddCityController::class, 'store'])->name('add_city_in_BD');

    Route::get('/profile/heroes_vov', [HeroesVovController::class, 'show'])->name('heroes_vov_profile_city');
    Route::get('/profile/heroes_svo', [HeroesSvoController::class, 'show'])->name('heroes_svo_profile_city');

    //--------------------------------------------
    // redirect to added heroes page
    //--------------------------------------------
    Route::get('/profile/heroes_vov/added_heroes', [HeroesAddedController::class, 'show'])->name('added_heroes_page_vov');
    Route::post('/profile/heroes_vov/added_heroes', [HeroesAddedController::class, 'show'])->name('added_heroes_page_vov');

    Route::get('/profile/heroes_svo/added_heroes', [HeroesAddedController::class, 'show'])->name('added_heroes_page_svo');
    Route::post('/profile/heroes_svo/added_heroes', [HeroesAddedController::class, 'show'])->name('added_heroes_page_svo');

    //--------------------------------------------
    // redirect to edit hero page
    //--------------------------------------------
    Route::post('/profile/heroes_vov/added_heroes/edit', [HeroesAddedController::class, 'edit_hero_user_page'])->name('edit_hero_user_page');
    Route::get('/profile/heroes_vov/added_heroes/edit', [HeroesAddedController::class, 'edit_hero_user_page'])->name('edit_hero_user_page');
    //--------------------------------------------
    // data changes in the database
    //--------------------------------------------
    Route::get('/profile/heroes_vov/added_heroes/edit/edit_in_bd', [HeroesAddController::class, 'edit_hero_user'])->name('edit_hero_user_in_bd');
    Route::post('/profile/heroes_vov/added_heroes/edit/edit_in_bd', [HeroesAddController::class, 'edit_hero_user'])->name('edit_hero_user_in_bd');



    //--------------------------------------------
    // redirect to add heroes page
    //--------------------------------------------
    Route::get('/profile/heroes_vov/added_heroes/add_heroes', [HeroesAddController::class, 'show'])->name('add_heroes_page_vov');
    Route::post('/profile/heroes_vov/added_heroes/add_heroes', [HeroesAddController::class, 'show'])->name('add_heroes_page_vov');
    Route::get('/profile/heroes_vov/added_heroes/add_heroes/add_heroes_in_BD', [HeroesAddController::class, 'store'])->name('add_heroes_in_BD');
    Route::post('/profile/heroes_vov/added_heroes/add_heroes/add_heroes_in_BD', [HeroesAddController::class, 'store'])->name('add_heroes_in_BD');

    Route::get('/profile/heroes_svo/added_heroes/add_heroes', [HeroesAddController::class, 'show'])->name('add_heroes_page_svo');
    Route::post('/profile/heroes_svo/added_heroes/add_heroes', [HeroesAddController::class, 'show'])->name('add_heroes_page_svo');


});

//--------------------------------------------
// debug for storage folder
//--------------------------------------------
Route::get('/debug_storage_hash_code-QWERSNBGRBNV11010012040123F1ND14', function () {
    $check = [];
    
    // checking the base path
    $check['storage_app_public'] = storage_path('app/public');
    $check['public_storage'] = public_path('storage');
    $check['storage_link_exists'] = file_exists(public_path('storage'));
    $check['is_link'] = is_link(public_path('storage'));
    
    if ($check['is_link']) {
        $check['link_target'] = readlink(public_path('storage'));
    }
    
    // checking access
    $check['storage_permissions'] = substr(sprintf('%o', fileperms(storage_path())), -4);
    $check['public_permissions'] = substr(sprintf('%o', fileperms(public_path())), -4);
    
    // trying to create a txt file
    Storage::disk('public')->put('debug_test.txt', 'Test content ' . now());
    $check['test_file_created'] = Storage::disk('public')->exists('debug_test.txt');
    $check['test_file_path'] = storage_path('app/public/debug_test.txt');
    $check['test_file_public_path'] = public_path('storage/debug_test.txt');
    $check['test_file_public_exists'] = file_exists(public_path('storage/debug_test.txt'));
    
    // URL for text
    $check['test_url'] = asset('storage/debug_test.txt');
    
    return $check;
});
