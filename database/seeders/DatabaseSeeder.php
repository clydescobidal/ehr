<?php

namespace Database\Seeders;

use App\Models\Department;
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

        $departments = [
            'admin' => [
                'owner',
                'administrator'
            ],
            'clinical' => [
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
                Role::firstOrCreate(['guard_name' => 'sanctum', 'department_id' => $department->id, 'name' => $role]);
            }
        }
    }
}
