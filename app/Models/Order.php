<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'first_name', 
        'last_name',
        'email',
        'address',
        'city',
        'postal_code',
        'country',
        'status',
        'price'
    ];

    protected static function boot()
    {
        parent::boot(); // Fixed typo: "parrent" to "parent"

        static::deleting(function($order) {
            // When deleting an order, handle related order products
            foreach($order->orderItems as $orderItem) {
                // Return quantity to product variant stock if needed
                $productVariant = ProductVariant::find($orderItem->product_variant_id);
                if($productVariant) {
                    // Increase available stock
                    $productVariant->stock += $orderItem->quantity;
                    $productVariant->save();
                }
                
                // Delete the order item
                $orderItem->delete();
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderProduct::class);
    }
}