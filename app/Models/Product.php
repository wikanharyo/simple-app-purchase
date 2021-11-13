<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'stock'
    ];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
