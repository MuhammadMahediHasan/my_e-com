<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductChildStock extends Model
{
    use HasFactory;
    protected $fillable = ['product_stock_id', 'product_id', 'size_id', 'color_id', 'quantity'];
}
