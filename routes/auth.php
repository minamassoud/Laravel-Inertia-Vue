<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware("guest")->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [AuthenticateController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticateController::class, 'store']);

    Route::get('/forgot-password', [ResetPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'email'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'show'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'update'])->name('password.update');
});


Route::middleware("auth")->group(function () {

    Route::post('/logout', [AuthenticateController::class, 'destroy'])->name('logout');

    Route::get('/email/verify', [EmailVerificationController::class, 'show'])->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}',
        [EmailVerificationController::class, 'store'])->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification',
        [EmailVerificationController::class, 'update'])->middleware('throttle:6,1')->name('verification.send');

    Route::get('/confirm-password', [ConfirmPasswordController::class, 'create'])->name('password.confirm');
    Route::post('/confirm-password', [ConfirmPasswordController::class, 'handle'])->middleware(['throttle:6,1']);
});
