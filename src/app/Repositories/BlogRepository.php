<?php

namespace App\Repositories;

use App\Models\Blog;

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
}

