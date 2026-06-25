<?php

use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Google OAuth (panel administrativo)
Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirect']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'callback']);
