<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth //
Route::prefix('auth')->group(function () {
    Route::post('login', 'Api\AuthController@signIn');
    Route::post('register', 'Api\AuthController@signUp');
});

// Categories //
Route::prefix('categories')->group(function () {
    Route::get('/', 'Api\CategoriesController@index');
});

// Middleware //
Route::middleware('auth:sanctum')->group(function () {
    // Auth //
    Route::prefix('auth')->group(function () {
        Route::post('logout', 'Api\AuthController@signOut');
    });
    // Categories //
    Route::prefix('categories')->group(function () {
        Route::post('/', 'Api\CategoriesController@store');
        Route::put('/{id}', 'Api\CategoriesController@update');
        Route::delete('/{id}', 'Api\CategoriesController@destroy');
    });
});

