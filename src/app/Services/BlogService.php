<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\ImageSection;
use App\Models\Tag;
use App\Models\TextSection;
use App\Repositories\BlogRepository;
use Illuminate\Http\Request;

class BlogService
{
    private $repository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->repository = $blogRepository;
    }

    public function index()
    {
        return $this->repository->query()->with(['tags', 'textSections', 'imageSections', 'user'])->get();
    }

    public function show($id)
    {
        return $this->repository->query()->with(['tags', 'textSections', 'imageSections', 'user'])->get()->find($id);
        //return $this->repository->query()->with(['tags', 'textSections', 'imageSections', 'user'])->find($id)->get();
    }

    public function destroy($id)
    {
        $this->repository->destroy($id);
    }

    public function store(Request $request)
    {
        $data = $request->except('_method', '_token');

        //Create blog, set title
        $blog = $this->repository->store($data['title']);

        //Attach tags for blog
        $tags = Tag::find($data['tags']);
        $blog->tags()->attach($tags);

        //Set text sections for blog
        foreach ($data['textSections'] as $textSection) {
            TextSection::create([
               'index' => $textSection['id'],
               'header' => $textSection['header'],
               'text' => $textSection['text'],
               'blog_id' => $blog->id
            ]);
        }

        //Save images
        foreach ($data['files'] as $image) {
            $path = $image['file']->store('blogs/section_images', 'public');
            ImageSection::create([
                'index' => $image['id'],
                'path' => $path,
                'blog_id' => $blog->id
            ]);
        }

        return $blog->id;
    }
}
