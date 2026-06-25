<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API (landing page)
|--------------------------------------------------------------------------
*/
Route::get('/destinations', [DestinationController::class, 'index']);
Route::get('/plans', [PlanController::class, 'index']);
Route::get('/settings', [SettingController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);
Route::post('/subscribe', [SubscriberController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Admin API (token Sanctum + middleware admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/me', [SocialAuthController::class, 'me']);
    Route::post('/logout', [SocialAuthController::class, 'logout']);

    // Destinos
    Route::get('/destinations', [DestinationController::class, 'all']);
    Route::post('/destinations', [DestinationController::class, 'store']);
    Route::get('/destinations/{destination}', [DestinationController::class, 'show']);
    Route::put('/destinations/{destination}', [DestinationController::class, 'update']);
    Route::delete('/destinations/{destination}', [DestinationController::class, 'destroy']);

    // Planes / promociones
    Route::get('/plans', [PlanController::class, 'all']);
    Route::post('/plans', [PlanController::class, 'store']);
    Route::get('/plans/{plan}', [PlanController::class, 'show']);
    Route::put('/plans/{plan}', [PlanController::class, 'update']);
    Route::delete('/plans/{plan}', [PlanController::class, 'destroy']);

    // Canales de atención
    Route::get('/settings', [SettingController::class, 'all']);
    Route::put('/settings', [SettingController::class, 'update']);

    // Mensajes de contacto
    Route::get('/messages', [ContactController::class, 'index']);
    Route::put('/messages/{message}/read', [ContactController::class, 'markRead']);
    Route::delete('/messages/{message}', [ContactController::class, 'destroy']);

    // Suscriptores
    Route::get('/subscribers', [SubscriberController::class, 'index']);
});
