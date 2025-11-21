<?php

use App\Http\Controllers\InviteController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/me', [UserController::class, 'me'])->middleware('auth:sanctum');

    // Tenants
    Route::group(['prefix' => 'tenants', 'middleware' => ['auth:sanctum']], function() {
        Route::post('/', [TenantController::class, 'create']);
    });

    // Invites
    Route::group(['prefix' => 'invites', 'middleware' => ['auth:sanctum']], function() {
        Route::post('/', [InviteController::class, 'create'])->scopeBindings();
    });
});