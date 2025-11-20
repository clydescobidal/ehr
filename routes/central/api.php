<?php

use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'tenants', 'middleware' => ['auth:sanctum']], function() {
    Route::post('/create', [TenantController::class, 'create']);
});