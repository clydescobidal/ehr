<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';

        throw_if(empty($tableNames), Exception::class, 'Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');


        Schema::create($tableNames['roles'], static function (Blueprint $table) use ($columnNames) {
            // $table->engine('InnoDB');
            $table->ulid('id', 30)->unique(); // role id
            $table->string('name');       // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
            $table->string('guard_name'); // For MyISAM use string('guard_name', 25);
            $table->ulid('department_id', 30)->nullable();
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });


        Schema::create($tableNames['model_has_roles'], static function (Blueprint $table) use ($tableNames, $columnNames, $pivotRole) {
            $table->ulid($pivotRole, 30);

            $table->string('model_type');
            $table->ulid($columnNames['model_morph_key'], 30);
            $table->ulid('department_id', 30)->nullable();
            $table->index([$columnNames['model_morph_key'], 'model_type', 'department_id'], 'model_has_roles_model_id_model_type_department_id_index');

            $table->foreign($pivotRole)
                ->references('id') // role id
                ->on($tableNames['roles'])
                ->cascadeOnDelete();

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->nullOnDelete();
    
            $table->primary([$pivotRole, $columnNames['model_morph_key'], 'model_type', 'department_id'],
                'model_has_roles_role_model_type_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');

        throw_if(empty($tableNames), Exception::class, 'Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');

        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['roles']);
    }
};
