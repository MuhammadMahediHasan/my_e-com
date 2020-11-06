<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'sub_category_id' , 'name', 'status'];

    public function sub_category(){
        return $this->belongsTo('App\Models\SubCategory', 'sub_category_id', 'id');
    }
}
