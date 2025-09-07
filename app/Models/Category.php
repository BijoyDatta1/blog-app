<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected   $table = 'categoris';
    protected $fillable = ['category_name', 'category_slug', 'status','user_id'];

    //createing auto slag
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->category_slug = Str::slug($category->category_name);
        });

        static::updating(function ($category) {
            $category->category_slug = Str::slug($category->category_name);
        });
    }
}
