<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require_once __DIR__ . "/auth.php";


Route::get('/', [ListingController::class, 'index'])->name('home');
Route::resource('listings', ListingController::class)->except('index');

Route::middleware(["auth"])->group(function () {

    Route::get('/profile', [ProfileController::class, 'create'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'updateInformation'])->name('profile.update-information');
    Route::put('/profile', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.delete');

    Route::middleware(['verified'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

});
