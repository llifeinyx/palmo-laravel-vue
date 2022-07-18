<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Models\Comment;
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
        //delete tags
        $blog = Blog::find($id);
        $blog->tags()->detach($blog->tags);

        //delete text sections
        $textSections = $blog->textSections;
        TextSection::destroy($textSections);

        //delete image sections
        $imageSections = $blog->imageSections;

        foreach ($imageSections as $imageSection) {
            unlink(public_path('storage/'.$imageSection->path));
        }

        ImageSection::destroy($imageSections);

        //delete comments
        $comments = $blog->comments;
        Comment::destroy($comments);

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

