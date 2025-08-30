<?php

use Illuminate\Support\Facades\Route;

require_once __DIR__ . "/auth.php";

Route::inertia('/', 'Home')->name('home');


Route::middleware(["auth", "verified"])->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

});
