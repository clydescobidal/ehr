<?php

use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/me', [UserController::class, 'me'])->middleware('auth:sanctum');
Route::group(['prefix' => 'tenants', 'middleware' => ['auth:sanctum']], function() {
    Route::post('/create', [TenantController::class, 'create']);
    Route::post('/{tenant:id}/invite-user', [TenantController::class, 'inviteUser'])->scopeBindings();
});