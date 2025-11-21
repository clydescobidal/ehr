<?php

declare(strict_types=1);

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

Route::get('/', function () {
    // Patient::create([
    //     'first_name' => 'Patient',
    //     'last_name' => 'test',
    //     'birth_date' => Carbon::now(),
    //     'birth_place' => 'Digos City',
    //     'occupation' => 'retired',
    //     'religion' => 'Christian',
    //     'contact_number' => '09654789898'
    // ]);
    $user = Auth::user();

    return Patient::all();
   return 'This is your multi-tenant application. The id of the current tenant is ' . tenant();
});
