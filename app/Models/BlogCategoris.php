<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategoris extends Model
{
    use HasFactory;
    protected $table = 'blog_categoris';
    protected $fillable = [
        'blog_id',
        'category_id',
    ];
}
