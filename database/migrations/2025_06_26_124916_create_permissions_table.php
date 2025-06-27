<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        $now = Carbon\Carbon::now();

        $permissions = [
            // Roles

            ['name' => 'Create Role', 'slug' => 'create-role'],
            ['name' => 'View Role', 'slug' => 'view-role'],
            ['name' => 'View Any Role', 'slug' => 'view-any-role'],
            ['name' => 'Edit Role', 'slug' => 'edit-role'],
            ['name' => 'Update Role', 'slug' => 'update-role'],
            ['name' => 'Delete Role', 'slug' => 'delete-role'],
            // Statuses

            ['name' => 'Create Status', 'slug' => 'create-status'],
            ['name' => 'View Status', 'slug' => 'view-status'],
            ['name' => 'View Any Status', 'slug' => 'view-any-status'],
            ['name' => 'Edit Status', 'slug' => 'edit-status'],
            ['name' => 'Update Status', 'slug' => 'update-status'],
            ['name' => 'Delete Status', 'slug' => 'delete-status'],
            // Permissions

            ['name' => 'Create Permission', 'slug' => 'create-permission'],
            ['name' => 'View Permission', 'slug' => 'view-permission'],
            ['name' => 'View Any Permission', 'slug' => 'view-any-permission'],
            ['name' => 'Edit Permission', 'slug' => 'edit-permission'],
            ['name' => 'Update Permission', 'slug' => 'update-permission'],
            ['name' => 'Delete Permission', 'slug' => 'delete-permission'],
            // Assignments

            ['name' => 'Assign Role', 'slug' => 'assign-role'],
            ['name' => 'Assign Status', 'slug' => 'assign-status'],
            ['name' => 'Assign Permission', 'slug' => 'assign-permission'],
        ];

        $data = array_map(function ($permission) use ($now) {
            return array_merge($permission, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $permissions);

        DB::table('permissions')->insert($data);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
