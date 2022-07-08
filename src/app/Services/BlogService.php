<?php

namespace App\Services;

use App\Repositories\BlogRepository;
use Illuminate\Http\Request;

class BlogService
{
    private $repository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->repository = $blogRepository;
    }
    public function store(Request $request)
    {
        $data = $request->except('_token','_method');

        return response()->json(['area' => 1]);
    }
}
