<?php

declare(strict_types=1);

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\PatientController;
use App\Models\Patient;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::group(['prefix' => 'patients'], function() {
    Route::post('/', [PatientController::class, 'create']);
});

Route::group(['prefix' => 'admissions'], function() {
    Route::post('/', [AdmissionController::class, 'create']);
});
