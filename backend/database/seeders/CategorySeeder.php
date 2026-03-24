<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Eletrônicos', 'slug' => 'eletronicos'],
            ['name' => 'Roupas', 'slug' => 'roupas'],
            ['name' => 'Calçados', 'slug' => 'calcados'],
            ['name' => 'Livros', 'slug' => 'livros'],
            ['name' => 'Casa', 'slug' => 'casa'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
