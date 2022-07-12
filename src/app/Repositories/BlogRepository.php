<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Models\ImageSection;
use App\Models\TextSection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;

class BlogRepository
{
    public function query()
    {
        return Blog::query();
    }

    public function index()
    {
        return $this->query()->get();
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->tags()->detach($blog->tags);

        $textSections = $blog->textSections;
        TextSection::destroy($textSections);

        $imageSections = $blog->imageSections;

        foreach ($imageSections as $imageSection) {
            unlink(public_path('storage/'.$imageSection->path));
        }

        ImageSection::destroy($imageSections);

        $blog->delete();
    }

    public function store($title)
    {
        $blog = Blog::create([
            'title' => $title,
            'user_id' => Auth::id()
        ]);

        return $blog;
    }

    public function update($title, Blog $blog)
    {
        $blog->update([
           'title' => $title
        ]);
    }
}

