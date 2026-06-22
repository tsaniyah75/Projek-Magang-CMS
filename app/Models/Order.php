<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'total_price',
        'status',
    ];

    /**
     * Relationship: Order has many items.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
