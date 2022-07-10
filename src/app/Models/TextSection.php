<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextSection extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'index',
        'header',
        'text',
        'blog_id'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
