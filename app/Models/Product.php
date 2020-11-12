<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;

class Product extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = ['name', 'slug', 'vendor_id', 'category_id', 'sub_category_id', 'child_category_id', 'purchase_price', 'sale_price', 'description'];


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category', 'category_id', 'id')->where('type',1);
    }

    public function sub_category(){
        return $this->belongsTo('App\Models\Category', 'sub_category_id', 'id')->where('type',2);
    }

    public function child_category(){
        return $this->belongsTo('App\Models\Category', 'child_category_id', 'id')->where('type',3);
    }

    public function vendor(){
        return $this->belongsTo('App\Models\User', 'vendor_id', 'id');
    }

    public function attribute(){
        return $this->hasMany('App\Models\ProductAttribute', 'product_id');
    }
}
