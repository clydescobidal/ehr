<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
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
        Role::firstOrCreate(['name' => 'owner', 'guard_name' => 'sanctum']);
        Role::firstOrCreate(['name' => 'administrator', 'guard_name' => 'sanctum']);
        Role::firstOrCreate(['name' => 'doctor', 'guard_name' => 'sanctum']);
        Role::firstOrCreate(['name' => 'nurse', 'guard_name' => 'sanctum']);
    }
}
