<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Tag;
use App\Repositories\BlogRepository;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private $service;

    public function __construct(BlogService $blogService)
    {
        $this->service = $blogService;
    }

    public function index()
    {
        $blogs = $this->service->index();

        return $blogs;
    }

    public function create()
    {
        //
    }

    public function store(BlogRequest $request)
    {

        $this->service->store($request);

        return $request;

//        $path = $file->store('test');

        //$this->service->store($request);
    }

    public function show($id)
    {
        $blog = $this->service->show($id);

        return $blog->toArray();
    }

    public function edit(Blog $blog)
    {
        //
    }

    public function update(Request $request, Blog $blog)
    {
        //
    }

    public function destroy(Blog $blog)
    {
        //
    }
}
