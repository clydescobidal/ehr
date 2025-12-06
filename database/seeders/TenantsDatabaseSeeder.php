<?php

namespace Database\Seeders;

use App\Models\ICD10Code;
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

        $codes = file_get_contents(database_path('seeders/icd10_codes.json'));
        $codes = json_decode($codes, true);
        foreach($codes as $code) {
            ICD10Code::updateOrCreate(
                [
                    'code' => $code['code']
                ],
                [
                    'description' => $code['desc']
                ]
            );
        }

        ICD10Code::all()->searchable();
    }
}
