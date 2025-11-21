<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (tenant()) {
            $this->command->warn("Running central database seeder within tenant's context. Skipping...");
            return;
        }

        Role::firstOrCreate(['name' => 'owner', 'guard_name' => 'sanctum']);
        Role::firstOrCreate(['name' => 'administrator', 'guard_name' => 'sanctum']);
    }
}
