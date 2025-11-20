<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTenantRequest;
use App\Models\Tenant;
use App\Models\TenantUser;
use Auth;
use Illuminate\Http\Request;
use Stancl\Tenancy\Database\Models\Domain;
use Str;

class TenantController extends Controller
{
    public function create(CreateTenantRequest $request) {
        $user = Auth::user();
        $name = $request->input('name');
        $dbName = $this->generateDatabaseName($name);

        $tenant = Tenant::create([
            'name' => $name,
            'tenancy_db_name' => $dbName
        ]);

        $tenantUser = TenantUser::create([
            'user_id' => $user->id,
            'tenant_id' => $tenant->id
        ]);

        $tenantUser->assignRole('owner');

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
