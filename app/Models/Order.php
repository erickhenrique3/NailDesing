<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'total_price', 'status'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

