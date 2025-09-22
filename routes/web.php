<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require_once __DIR__ . "/auth.php";

Route::inertia('/', 'Home')->name('home');


Route::middleware(["auth"])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile-information',
        [ProfileController::class, 'updateInformation'])->name('profile.update-information');

});
