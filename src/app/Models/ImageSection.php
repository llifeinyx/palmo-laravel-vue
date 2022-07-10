<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageSection extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'index',
        'path',
        'blog_id'
    ];

    public function blog() {
        return $this->belongsTo(Blog::class);
    }
}
