<?php

use App\Http\Controllers\Auth\CityAndHeroes\AddCityController;

//======================================
// use => heroes vov, svo and mp (main)
//======================================
use App\Http\Controllers\Main\HeroesAndMPMainController;

//=================================================
// use => heroes and memorable places in profile
//=================================================
// added => heroes and memorable places
use App\Http\Controllers\Auth\HeroesMPActions\HeroesAddedController;
use App\Http\Controllers\Auth\HeroesMPActions\MPAddedController;

// actions => heroes and memorable places
use App\Http\Controllers\Auth\HeroesMPActions\HeroActionsController;
use App\Http\Controllers\Auth\HeroesMPActions\MPActionsController;

use App\Http\Controllers\HeroesVovController;
use App\Http\Controllers\HeroesSvoController;
use App\Http\Controllers\MemorablePlacesController;

//=================================================
// use => different function for profile 
//=================================================
// accounts
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\BannedController;
use App\Http\Controllers\Auth\ProfileController;

use App\Http\Controllers\PoliticPolicyController;

//--------------------------------------------
// for main page
//--------------------------------------------
Route::view('/', 'main')->name('main');

//----------------------------------
// Route for heroes vov, svo and mp
//----------------------------------
Route::get('/heroes_vov_choosing_city', [HeroesAndMPMainController::class, 'show_city_heroes_vov'])->name('heroes_vov_choosing_city');
Route::get('/heroes_svo_choosing_city', [HeroesAndMPMainController::class, 'show_city_heroes_svo'])->name('heroes_svo_choosing_city');

//-------------------------------------------------------------
// show heroes vov, svo and mp (показать героев ВОВ, СВО и ПМ)
//-------------------------------------------------------------
Route::get('/heroes_vov_choosing_city/heroes_vov', [HeroesAndMPMainController::class, 'show_heroes_vov'])->name('heros_vov_main');
Route::post('/heroes_vov_choosing_city/heroes_vov', [HeroesAndMPMainController::class, 'show_heroes_vov'])->name('heros_vov_main');

Route::get('/heroes_svo_choosing_city/heroes_svo', [HeroesAndMPMainController::class, 'show_heroes_svo'])->name('heros_svo_main');
Route::post('/heroes_svo_choosing_city/heroes_svo', [HeroesAndMPMainController::class, 'show_heroes_svo'])->name('heros_svo_main');


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
    Route::get('/profile/heroes_vov/added_heroes/edit', [HeroesAddedController::class, 'edit_hero_user'])->name('edit_hero_user');
    Route::post('/profile/heroes_vov/added_heroes/edit', [HeroesAddedController::class, 'edit_hero_user'])->name('edit_hero_user');

    Route::get('/profile/heroes_vov/added_heroes/edit', [HeroesAddedController::class, 'edit_hero_user_page'])->name('edit_hero_user_page');
    Route::post('/profile/heroes_vov/added_heroes/edit', [HeroesAddedController::class, 'edit_hero_user_page'])->name('edit_hero_user_page');

    //--------------------------------------------
    // data changes in the database
    //--------------------------------------------
    Route::get('/profile/heroes_vov/added_heroes/edit/update', [HeroActionsController::class, 'edit_hero_user'])->name('edit_hero_user_in_bd');
    Route::post('/profile/heroes_vov/added_heroes/edit/update', [HeroActionsController::class, 'edit_hero_user'])->name('edit_hero_user_in_bd');

    //--------------------------------------------
    // delete hero
    //--------------------------------------------
    Route::post('/profile/heroes_vov/added_heroes/deleting',[HeroActionsController::class, 'delete_hero'])->name('delete_hero');

    //--------------------------------------------
    // redirect to add heroes page
    //--------------------------------------------
    Route::get('/profile/heroes_vov/added_heroes/add_heroes', [HeroActionsController::class, 'show'])->name('add_heroes_page_vov');
    Route::post('/profile/heroes_vov/added_heroes/add_heroes', [HeroActionsController::class, 'show'])->name('add_heroes_page_vov');
    Route::get('/profile/heroes_vov/added_heroes/add_heroes/add_heroes_in_BD', [HeroActionsController::class, 'store'])->name('add_heroes_in_BD');
    Route::post('/profile/heroes_vov/added_heroes/add_heroes/add_heroes_in_BD', [HeroActionsController::class, 'store'])->name('add_heroes_in_BD');

    Route::get('/profile/heroes_svo/added_heroes/add_heroes', [HeroActionsController::class, 'show'])->name('add_heroes_page_svo');
    Route::post('/profile/heroes_svo/added_heroes/add_heroes', [HeroActionsController::class, 'show'])->name('add_heroes_page_svo');

    //=========================================
    // memorable places 
    //========================================
    Route::get('/profile/memorable_places', [MemorablePlacesController::class, 'show'])->name('mp_profile_city');
    Route::post('/profile/memorable_places', [MemorablePlacesController::class, 'show'])->name('mp_profile_city');

    //=========================================
    // redirect to added memorable places page
    //=========================================
    Route::get('/profile/memorable_places/added_mp', [MPAddedController::class, 'show'])->name('added_mp_page');
    Route::post('/profile/memorable_places/added_mp', [MPAddedController::class, 'show'])->name('added_mp_page');
    
    //=========================================
    // redirect to add memorable place page
    //=========================================
    Route::get('/profile/added_mp/add_mp', [MPActionsController::class, 'show'])->name('add_mp_page');
    Route::post('/profile/added_mp/add_mp', [MPActionsController::class, 'show'])->name('add_mp_page');
    Route::get('/profile/added_mp/add_mp/add_mp_in_BD', [MPActionsController::class, 'store'])->name('add_mp_in_BD');
    Route::post('/profile/added_mp/add_mp/add_mp_in_BD', [MPActionsController::class, 'store'])->name('add_mp_in_BD');

    //=========================================
    // redirect to edit memorable place page
    //=========================================
    Route::get('/profile/memorable_places/added_mp/edit', [MPActionsController::class, 'edit_mp_user'])->name('edit_mp_user');
    Route::post('/profile/memorable_places/added_mp/edit', [MPActionsController::class, 'edit_mp_user'])->name('edit_mp_user');

    Route::get('/profile/memorable_places/added_mp/edit', [MPAddedController::class, 'edit_mp_user_page'])->name('edit_mp_user_page');
    Route::post('/profile/memorable_places/added_mp/edit', [MPAddedController::class, 'edit_mp_user_page'])->name('edit_mp_user_page');

    //=========================================
    // data changes in the database
    //=========================================
    Route::get('/profile/memorable_places/added_mp/edit/update', [MPActionsController::class, 'edit_mp_user'])->name('edit_mp_user_in_bd');
    Route::post('/profile/memorable_places/added_mp/edit/update', [MPActionsController::class, 'edit_mp_user'])->name('edit_mp_user_in_bd');

    //=========================================
    // delete memorable place
    //=========================================
    Route::post('/profile/memorable_places/added_mp/deleting',[MPActionsController::class, 'delete_mp'])->name('delete_mp');
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
