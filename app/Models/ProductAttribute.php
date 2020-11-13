<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'type','color_id', 'size_id'];

    public function color(){
        return $this->belongsTo('App\Models\Color','color_id','id');
    }

    public function size(){
        return $this->belongsTo('App\Models\Size','size_id','id');
    }
}
