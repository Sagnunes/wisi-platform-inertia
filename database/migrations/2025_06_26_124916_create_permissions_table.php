<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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

        DB::table('permissions')->insert([
            [
                'name' => 'Create Role',
                'slug' => 'roles.create',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Read Role',
                'slug' => 'roles.read',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Update Role',
                'slug' => 'roles.update',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Delete Role',
                'slug' => 'roles.delete',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Create Status',
                'slug' => 'statuses.create',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Read Status',
                'slug' => 'statuses.read',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Update Status',
                'slug' => 'statuses.update',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Delete Status',
                'slug' => 'statuses.delete',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Create Permission',
                'slug' => 'permissions.create',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Read Permission',
                'slug' => 'permissions.read',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Update Permission',
                'slug' => 'permissions.update',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Delete Permission',
                'slug' => 'permissions.delete',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Optional assignment permissions
            [
                'name' => 'Assign Role',
                'slug' => 'roles.assign',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Assign Status',
                'slug' => 'statuses.assign',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Assign Permission',
                'slug' => 'permissions.assign',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
