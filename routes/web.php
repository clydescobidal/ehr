<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('patients', function () {
    return Inertia::render('patients/List');
})->middleware(['auth', 'verified'])->name('patients');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
