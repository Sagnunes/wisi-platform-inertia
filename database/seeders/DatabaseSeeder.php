<?php

namespace Database\Seeders;

use App\Enums\StatusesEnum;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'status_id' => StatusesEnum::ACTIVE,
        ]);

        \Illuminate\Support\Facades\DB::table('role_user')->insert([
            ['user_id' => 1, 'role_id' => 1, 'created_by_id' => 1, 'created_at' => \Carbon\Carbon::now()],
        ]);
    }
}
