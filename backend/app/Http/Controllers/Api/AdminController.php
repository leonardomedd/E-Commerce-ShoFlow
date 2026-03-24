<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Get dashboard stats
     */
    public function dashboard()
    {
        $total_orders = Order::count();
        $total_revenue = Order::sum('total');
        $pending_orders = Order::where('status', 'pending')->count();
        $total_products = Product::count();
        $low_stock_products = Product::where('stock', '<', 10)->count();

        return response()->json([
            'data' => [
                'total_orders' => $total_orders,
                'total_revenue' => $total_revenue,
                'pending_orders' => $pending_orders,
                'total_products' => $total_products,
                'low_stock_products' => $low_stock_products,
            ],
        ], 200);
    }

    /**
     * Create product
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|string',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product,
        ], 201);
    }

    /**
     * Update product
     */
    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'exists:categories,id',
            'name' => 'string|max:255',
            'slug' => 'string|max:255|unique:products,slug,' . $product->id,
            'description' => 'string',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'image_url' => 'nullable|string',
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product,
        ], 200);
    }

    /**
     * Delete product
     */
    public function destroyProduct(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
        ], 200);
    }

    /**
     * Update order status
     */
    public function updateOrder(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update($validated);

        return response()->json([
            'message' => 'Order status updated',
            'data' => $order,
        ], 200);
    }

    /**
     * Get all orders
     */
    public function orders()
    {
        $orders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'data' => $orders->items(),
            'pagination' => [
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
            ],
        ], 200);
    }

    /**
     * Get all products
     */
    public function products()
    {
        $products = Product::with('category')
            ->paginate(20);

        return response()->json([
            'data' => $products->items(),
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ],
        ], 200);
    }
}
