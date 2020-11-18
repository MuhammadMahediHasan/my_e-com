<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTotalStock extends Model
{
    use HasFactory;
    protected $fillable = ['sku', 'product_id', 'size_id', 'color_id', 'quantity'];



    public function product(){
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function color(){
        return $this->belongsTo('App\Models\Color', 'color_id', 'id');
    }

    public function size(){
        return $this->belongsTo('App\Models\Size', 'size_id', 'id');
    }
}
