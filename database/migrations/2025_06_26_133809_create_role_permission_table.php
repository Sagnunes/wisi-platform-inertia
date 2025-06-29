<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Role::class)->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(\App\Models\Permission::class)->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });

        $permissions = \App\Models\Permission::all();

        $permissions->each(function ($permission) {
            $permission->roles()->attach(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }
};
