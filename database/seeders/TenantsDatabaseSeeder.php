<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantsDatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if ( !tenant()) {
            $this->command->warn("Running tenant database seeder within central's context. Skipping...");
            return;
        }

        $departments = [
            'medical' => [
                'doctor',
                'nurse'
            ],
            'billing' => [
                'cashier',
                'hmo'
            ],
            'pharmacy' => [
                'pharmacist'
            ],
            'radiology' => [
                'radio_technologist'
            ],
            'laboratory' => [
                'medical_technologist'
            ]
        ];

        foreach($departments as $department => $roles) {
            $department = Department::firstOrCreate(['name' => $department]);
            foreach($roles as $role) {
                Role::firstOrCreate(['department_id' => $department->id, 'name' => $role]);
            }
        }
    }
}
