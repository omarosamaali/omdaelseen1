<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Places;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('o1m2r3e4l5'),
            'role' => 'admin',
            'phone' => '0123456789',
            'country' => 'EG',
            'language' => 'en',
            'created_at' => now(),
            'updated_at' => now(),
            
        ]);


        User::factory()->create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('o1m2r3e4l5'),
            'role' => 'user',
            'phone' => '0123456781',
            'country' => 'EG',
            'language' => 'en',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        Places::factory(20)->create();


    }
}
