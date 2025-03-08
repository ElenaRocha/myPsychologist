<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('landing');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
