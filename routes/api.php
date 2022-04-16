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

// Payment Methods //
Route::prefix('payment-methods')->group(function () {
    Route::get('/', 'Api\PaymentMethodsController@index');
});

// Products //
Route::prefix('products')->group(function () {
    Route::get('/', 'Api\ProductsController@index');
    Route::get('/{id}', 'Api\ProductsController@show');
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
    // Products //
    Route::prefix('products')->group(function () {
        Route::post('/', 'Api\ProductsController@store');
        Route::put('/{id}', 'Api\ProductsController@update');
        Route::delete('/{id}', 'Api\ProductsController@destroy');
    });
    // Customers //
    Route::prefix('customers')->group(function () {
        Route::get('/', 'Api\CustomersController@index');
        Route::get('/{id}', 'Api\CustomersController@show');
        Route::post('/', 'Api\CustomersController@store');
        Route::put('/{id}', 'Api\CustomersController@update');
        Route::delete('/{id}', 'Api\CustomersController@destroy');
    });
    // Sales //
    Route::prefix('sales')->group(function () {
        Route::get('/', 'Api\SalesController@index');
        Route::get('/{id}', 'Api\SalesController@show');
        Route::post('/', 'Api\SalesController@store');
        Route::delete('/{id}', 'Api\SalesController@destroy');
    });
});

