<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Get all categories with product count
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();

        return response()->json([
            'data' => $categories,
        ], 200);
    }
}
