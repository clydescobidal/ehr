<?php

use App\Http\Controllers\InviteController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/me', [UserController::class, 'me']);

    // Tenants
    Route::group(['prefix' => 'tenants'], function() {
        Route::post('/', [TenantController::class, 'create']);
    });

    // Invites
    Route::group(['prefix' => 'invites'], function() {
        Route::post('/', [InviteController::class, 'create']);
        Route::get('/', [InviteController::class, 'list']);
        Route::post('/accept', [InviteController::class, 'accept']);
    });
});