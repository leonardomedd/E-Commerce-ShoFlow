<?php

namespace Database\Seeders;

use App\Models\User;
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
        // Create categories and products
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        // Create admin user
        User::create([
            'name' => 'Admin ShopFlow',
            'email' => 'admin@shopflow.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create 10 customer users
        User::factory(10)->create([
            'role' => 'customer',
        ]);
    }
}
