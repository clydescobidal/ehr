<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTenantRequest;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Stancl\Tenancy\Database\Models\Domain;
use Str;

class TenantController extends Controller
{
    public function create(CreateTenantRequest $request) {
        $name = $request->input('name');
        $dbName = $this->generateDatabaseName($name);

        $tenant = Tenant::create([
            'name' => $name,
            'tenancy_db_name' => $dbName
        ]);

        return $tenant;
    }

    protected function generateDatabaseName(string $name) {
        $databaseName = Str::snake($name);
        $prefixedDatabaseName = $databaseName;
        $prefix = 0;

        while (true) {
            if (Tenant::where('data->tenancy_db_name', $prefixedDatabaseName)->doesntExist()) {
                break;
            }

            $prefix++;
            $prefixedDatabaseName = "{$databaseName}_{$prefix}";
        }

        return $prefixedDatabaseName;
    }
}
