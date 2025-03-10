<?php

namespace App\Http\Controllers;

use App\Models\Order; // Missing Order model import
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB; // Wrong DB import
use Illuminate\Http\Request;

class OrderController extends Controller 
{
    public function createOrder(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'postal_code' => ['required', 'string'],
            'country' => ['required', 'string'],
            'products' => ['required', 'array'],
            'products.*.product_variant_id' => ['required', 'exists:product_variants,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();
        $user = $request->user();

        try {
            // Calculate total price (this is missing in your code)
            $totalPrice = 0;
            foreach ($request->products as $item) {
                $variant = ProductVariant::findOrFail($item['product_variant_id']);
                $totalPrice += $variant->price * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => $request->user()->id, 
                'phone' => $request->phone,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'status' => 'PENDING',
                'price' => $totalPrice,
            ]);
            
            // Store order items
            foreach ($request->products as $item) {
                $order->orderItems()->create([
                    'product_variant_id' => $item['product_variant_id'],
                    'quantity' => $item['quantity'],
                    'price' => ProductVariant::findOrFail($item['product_variant_id'])->price,
                ]);
            }
            
            DB::commit();
            return response()->json(['order' => $order], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}