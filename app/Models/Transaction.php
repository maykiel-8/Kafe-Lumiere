<?php
// app/Models/Transaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_number',
        'cashier_id',
        'customer_user_id',     // added — links to registered customer account (null for walk-ins)
        'customer_name',
        'customer_email',
        'payment_method',
        'subtotal',
        'tax',
        'total',
        'amount_tendered',
        'change',
        'status',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    // The registered customer who placed this order (null for walk-ins)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate a unique order number
     * Format: ORD-YYYYMMDDHHMMSS
     */
    public static function generateOrderNumber(): string
    {
        return 'ORD-' . now()->format('YmdHis');
    }
}