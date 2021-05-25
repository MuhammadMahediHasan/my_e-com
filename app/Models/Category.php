<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory;
    use HasSlug;
    protected $fillable = ['name', 'slug', 'description', 'sub_category_id', 'child_category_id', 'type', 'status', 'created_by', 'updated_by'];


    public static function boot() {
        parent::boot();
        static::saving(function($model){
            $model->created_by = isset(auth()->user()->id) ? auth()->user()->id  : null;
        });

        static::updating(function($model){
            $model->updated_by = isset(auth()->user()->id) ? auth()->user()->id  : null;
        });
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category(){
        return $this->belongsTo(__Class__, 'sub_category_id', 'id');
    }

    public function sub_category(){
        return $this->belongsTo(__Class__, 'child_category_id', 'id');
    }

    public function sub_categories() {
        return $this->hasMany(__Class__, 'sub_category_id')->whereType(2);
    }

    public function child_categories() {
        return $this->hasMany(__Class__, 'child_category_id')->whereType(3);
    }
}
