<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware("guest")->group(function(){
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [AuthenticateController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticateController::class, 'store']);

    Route::get('/forgot-password', [AuthenticateController::class, 'create'])->name('forgotPassword');
});


Route::middleware("auth")->group(function(){

    Route::post('/logout', [AuthenticateController::class, 'destroy'])->name('logout');

    Route::get('/email/verify', [EmailVerificationController::class, 'show'])->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}',
        [EmailVerificationController::class, 'store'])->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification',
        [EmailVerificationController::class, 'update'])->middleware('throttle:6,1')->name('verification.send');
});
