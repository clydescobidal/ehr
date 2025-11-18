<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('patients/{id}', [PatientController::class, 'info'])->name('patients.info');
});
