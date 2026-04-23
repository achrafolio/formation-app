<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormationController;

Route::get('/', function () {
    return view('home');
});

Route::resource('formations', FormationController::class);
