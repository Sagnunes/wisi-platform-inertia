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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        $now = Carbon\Carbon::now();
        DB::table('statuses')->insert([
            ['name' => 'Pendente', 'slug' => 'pendente', 'created_at' => $now],
            ['name' => 'Ativo', 'slug' => 'ativo', 'created_at' => $now],
            ['name' => 'Bloqueado', 'slug' => 'bloqueado', 'created_at' => $now],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
