<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'status',
        'display',
        'user_id'

    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function blogCategoris(){
        return $this->belongsToMany(BlogCategoris::class);
    }
    protected static function boot(){
        parent::boot();
        static::creating(function($blog){
            $blog->slug = Str::slug($blog->title);
        });
        static::updating(function($blog){
            $blog->slug = Str::slug($blog->title);
        });
    }
}
