<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ImageController extends Controller
{
    public function placeholder($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Cores e ícones por categoria
        $categoryStyles = [
            1 => ['bg' => '#3B82F6', 'icon' => '📱', 'name' => 'Eletrônicos'],
            2 => ['bg' => '#EC4899', 'icon' => '👕', 'name' => 'Roupas'],
            3 => ['bg' => '#F59E0B', 'icon' => '👠', 'name' => 'Sapatos'],
            4 => ['bg' => '#10B981', 'icon' => '📚', 'name' => 'Livros'],
            5 => ['bg' => '#8B5CF6', 'icon' => '🏠', 'name' => 'Casa'],
        ];

        $style = $categoryStyles[$product->category_id] ?? ['bg' => '#6B7280', 'icon' => '📦', 'name' => 'Produto'];
        
        $productName = htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8');
        
        // SVG placeholder com gradiente
        $svg = <<<SVG
<svg width="400" height="400" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:{$style['bg']};stop-opacity:1" />
      <stop offset="100%" style="stop-color:#ffffff;stop-opacity:0.2" />
    </linearGradient>
  </defs>
  
  <rect width="400" height="400" fill="url(#grad)"/>
  
  <text x="200" y="150" font-size="80" text-anchor="middle" fill="white" font-family="Arial, sans-serif" opacity="0.9">
    {$style['icon']}
  </text>
  
  <text x="200" y="220" font-size="24" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-weight="bold" text-anchor="middle">
    <tspan x="200" dy="0">{$productName}</tspan>
  </text>
  
  <text x="200" y="320" font-size="18" text-anchor="middle" fill="white" font-family="Arial, sans-serif" opacity="0.9">
    {$style['name']}
  </text>
</svg>
SVG;

        header('Content-Type: image/svg+xml');
        header('Cache-Control: public, max-age=86400');
        echo $svg;
    }
}
