<?php

namespace App\Tenancy;

use App\Models\Tenant;
use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Spatie\Permission\PermissionRegistrar;
class SpatiePermissionsBootstrapper implements TenancyBootstrapper
{
    public function __construct(
        protected PermissionRegistrar $registrar,
    ) {}

    public function bootstrap(\Stancl\Tenancy\Contracts\Tenant $tenant)
    {
        $this->registrar->cacheKey = 'spatie.permission.cache.tenant.' . $tenant->getTenantKey();
    }

    public function revert()
    {
        $this->registrar->cacheKey = 'spatie.permission.cache';
    }
}