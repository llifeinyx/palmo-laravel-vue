<?php

namespace App\Repositories;

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogRepository
{
    private function query()
    {
        return Blog::query();
    }

    public function index()
    {
        return $this->query()->get();
    }

    public function store($title)
    {
        $blog = Blog::create([
            'title' => $title,
            'user_id' => Auth::id()
        ]);

        return $blog;
    }
}

