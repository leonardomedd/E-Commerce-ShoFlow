<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Eletrônicos
            ['category_id' => 1, 'name' => 'Smartphone Samsung Galaxy S24', 'price' => 3999.00, 'stock' => 50, 'image_url' => 'https://via.placeholder.com/300x300?text=Galaxy+S24'],
            ['category_id' => 1, 'name' => 'Notebook Dell Inspiron 15', 'price' => 4499.00, 'stock' => 30, 'image_url' => 'https://via.placeholder.com/300x300?text=Dell+Inspiron'],
            ['category_id' => 1, 'name' => 'Fone de Ouvido JBL T750', 'price' => 199.00, 'stock' => 100, 'image_url' => 'https://via.placeholder.com/300x300?text=JBL+T750'],
            ['category_id' => 1, 'name' => 'Câmera Digital Sony Alpha', 'price' => 2899.00, 'stock' => 25, 'image_url' => 'https://via.placeholder.com/300x300?text=Sony+Alpha'],
            ['category_id' => 1, 'name' => 'Tablet Apple iPad Air', 'price' => 2499.00, 'stock' => 40, 'image_url' => 'https://via.placeholder.com/300x300?text=iPad+Air'],
            ['category_id' => 1, 'name' => 'Smartwatch Samsung Galaxy Watch', 'price' => 899.00, 'stock' => 60, 'image_url' => 'https://via.placeholder.com/300x300?text=Galaxy+Watch'],
            
            // Roupas
            ['category_id' => 2, 'name' => 'Camiseta Básica Branca', 'price' => 49.90, 'stock' => 200, 'image_url' => 'https://via.placeholder.com/300x300?text=Camiseta+Branca'],
            ['category_id' => 2, 'name' => 'Calça Jeans Azul Escuro', 'price' => 129.90, 'stock' => 150, 'image_url' => 'https://via.placeholder.com/300x300?text=Calça+Jeans'],
            ['category_id' => 2, 'name' => 'Jaqueta Bomber Preta', 'price' => 249.90, 'stock' => 80, 'image_url' => 'https://via.placeholder.com/300x300?text=Jaqueta+Bomber'],
            ['category_id' => 2, 'name' => 'Vestido Festa Vermelho', 'price' => 199.90, 'stock' => 50, 'image_url' => 'https://via.placeholder.com/300x300?text=Vestido+Vermelho'],
            ['category_id' => 2, 'name' => 'Camisa Social Branca', 'price' => 159.90, 'stock' => 100, 'image_url' => 'https://via.placeholder.com/300x300?text=Camisa+Social'],
            ['category_id' => 2, 'name' => 'Short Denim Premium', 'price' => 99.90, 'stock' => 120, 'image_url' => 'https://via.placeholder.com/300x300?text=Short+Denim'],
            
            // Calçados
            ['category_id' => 3, 'name' => 'Tênis Nike Air Max', 'price' => 449.90, 'stock' => 90, 'image_url' => 'https://via.placeholder.com/300x300?text=Nike+Air+Max'],
            ['category_id' => 3, 'name' => 'Sapato Social Preto', 'price' => 279.90, 'stock' => 70, 'image_url' => 'https://via.placeholder.com/300x300?text=Sapato+Social'],
            ['category_id' => 3, 'name' => 'Sandália Havaianas', 'price' => 89.90, 'stock' => 150, 'image_url' => 'https://via.placeholder.com/300x300?text=Havaianas'],
            ['category_id' => 3, 'name' => 'Bota de Couro Premium', 'price' => 389.90, 'stock' => 60, 'image_url' => 'https://via.placeholder.com/300x300?text=Bota+Couro'],
            ['category_id' => 3, 'name' => 'Sapato Feminino Salto', 'price' => 199.90, 'stock' => 80, 'image_url' => 'https://via.placeholder.com/300x300?text=Sapato+Salto'],
            ['category_id' => 3, 'name' => 'Chinelo Confortável', 'price' => 59.90, 'stock' => 200, 'image_url' => 'https://via.placeholder.com/300x300?text=Chinelo'],
            
            // Livros
            ['category_id' => 4, 'name' => 'Clean Code - Robert Martin', 'price' => 89.90, 'stock' => 40, 'image_url' => 'https://via.placeholder.com/300x300?text=Clean+Code'],
            ['category_id' => 4, 'name' => 'O Hobbit - J.R.R. Tolkien', 'price' => 54.90, 'stock' => 60, 'image_url' => 'https://via.placeholder.com/300x300?text=Hobbit'],
            ['category_id' => 4, 'name' => '1984 - George Orwell', 'price' => 49.90, 'stock' => 70, 'image_url' => 'https://via.placeholder.com/300x300?text=1984'],
            ['category_id' => 4, 'name' => 'Design Patterns - Gang of Four', 'price' => 99.90, 'stock' => 35, 'image_url' => 'https://via.placeholder.com/300x300?text=Design+Patterns'],
            ['category_id' => 4, 'name' => 'Refatoração - Martin Fowler', 'price' => 79.90, 'stock' => 45, 'image_url' => 'https://via.placeholder.com/300x300?text=Refatoração'],
            ['category_id' => 4, 'name' => 'O Senhor dos Anéis - Tolkien', 'price' => 129.90, 'stock' => 50, 'image_url' => 'https://via.placeholder.com/300x300?text=Senhor+Anéis'],
            
            // Casa
            ['category_id' => 5, 'name' => 'Luminária LED Moderna', 'price' => 89.90, 'stock' => 80, 'image_url' => 'https://via.placeholder.com/300x300?text=Luminária+LED'],
            ['category_id' => 5, 'name' => 'Almofada Decorativa', 'price' => 39.90, 'stock' => 150, 'image_url' => 'https://via.placeholder.com/300x300?text=Almofada'],
            ['category_id' => 5, 'name' => 'Tapete Persa', 'price' => 299.90, 'stock' => 40, 'image_url' => 'https://via.placeholder.com/300x300?text=Tapete+Persa'],
            ['category_id' => 5, 'name' => 'Espelho Decorativo Redondo', 'price' => 149.90, 'stock' => 60, 'image_url' => 'https://via.placeholder.com/300x300?text=Espelho+Redondo'],
            ['category_id' => 5, 'name' => 'Cortina Blackout', 'price' => 129.90, 'stock' => 75, 'image_url' => 'https://via.placeholder.com/300x300?text=Cortina+Blackout'],
            ['category_id' => 5, 'name' => 'Prateleira Flutuante', 'price' => 99.90, 'stock' => 100, 'image_url' => 'https://via.placeholder.com/300x300?text=Prateleira'],
        ];

        foreach ($products as $product) {
            $product['description'] = 'Produto de qualidade superior com excelente acabamento e durabilidade.';
            $product['slug'] = Str::slug($product['name']);
            Product::create($product);
        }
    }
}
