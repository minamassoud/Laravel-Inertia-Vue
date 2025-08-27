<?php

use Illuminate\Support\Facades\Route;

require_once __DIR__ . "/auth.php";

Route::inertia('/', 'Home')->name('home');
