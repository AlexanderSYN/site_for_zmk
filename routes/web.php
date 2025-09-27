<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// for staticsic the pages
Route::get('/page/{slug}', function ($slug) {
    if (view()->exists("pages.{$slug}")) {
        return view("pages.{$slug}");
    }
    abort(404);
});
