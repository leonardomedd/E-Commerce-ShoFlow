<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Create an order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => $request->user()->id,
            'status' => 'pending',
            'total' => 0,
        ]);

        $total = 0;
        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);
            
            // Check stock
            if ($product->stock < $item['quantity']) {
                $order->delete();
                return response()->json([
                    'error' => "Product {$product->name} out of stock",
                ], 400);
            }

            $subtotal = $product->price * $item['quantity'];
            $total += $subtotal;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
            ]);

            // Decrease stock
            $product->decrement('stock', $item['quantity']);
        }

        $order->update(['total' => $total]);

        return response()->json([
            'message' => 'Order created successfully',
            'data' => $order->load('items.product'),
        ], 201);
    }

    /**
     * Get user's orders
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'data' => $orders,
        ], 200);
    }

    /**
     * Get a specific order
     */
    public function show(Request $request, Order $order)
    {
        // Check if user owns this order or is admin
        if ($order->user_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'data' => $order->load('items.product'),
        ], 200);
    }
}
