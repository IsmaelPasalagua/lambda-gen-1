<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth //
Route::prefix('auth')->group(function () {
    Route::post('login', 'Api\AuthController@signIn');
    Route::post('register', 'Api\AuthController@signUp');
});

// Middleware //
Route::middleware('auth:sanctum')->group(function () {
    // Auth //
    Route::prefix('auth')->group(function () {
        Route::post('logout', 'Api\AuthController@signOut');
    });
});

