<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'user_id'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function textSections()
    {
        return $this->hasMany(TextSection::class);
    }
    public function imageSections()
    {
        return $this->hasMany(ImageSection::class);
    }
}
