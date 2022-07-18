<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Comment;
use App\Policies\BlogPolicy;
use App\Policies\CommentPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Blog::class => BlogPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    public function register()
    {
        //
    }

    public function boot()
    {
        //
    }
}
