<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Who placed the order
        'status',  // For tracking order status (e.g., pending, completed, etc.)
        'total_price', // The total price of the order
        'shipping_address',
        'payment_status',
        'payment_provider',
        'payment_transaction_id',
        'placed_at',
        'completed_at',
    ];

    protected $casts = [
        'placed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Define the relationship with the User model (user who placed the order)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Product model (products included in the order)
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price');
    }
}
