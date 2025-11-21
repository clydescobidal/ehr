<?php

namespace App\Listeners;

use Artisan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Stancl\Tenancy\Events\TenantCreated;

class SeedTenantDatabase
{
    /**
     * Handle the event.
     */
    public function handle(TenantCreated $event)
    {
        $tenant = $event->tenant;

        $tenant->run(function () {
            Artisan::call('db:seed', [
                '--class' => 'TenantsDatabaseSeeder',
                '--force' => true,
            ]);
        });
    }
}
