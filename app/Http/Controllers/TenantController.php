<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTenantRequest;
use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use App\Models\TenantUser;
use Auth;
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

        return TenantResource::make($tenant);
    }

    protected function generateDatabaseName(string $name) {
        $databaseName = Str::snake($name);
        $prefixedDatabaseName = "tenant_$databaseName";
        $prefix = 0;

        while (true) {
            if (Tenant::where('data->tenancy_db_name', $prefixedDatabaseName)->doesntExist()) {
                break;
            }

            $prefix++;
            $prefixedDatabaseName = "tenant_{$databaseName}_{$prefix}";
        }

        return $prefixedDatabaseName;
    }
}
