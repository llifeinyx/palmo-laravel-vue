<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;

class CommentRepository
{
    public function query()
    {
        return Comment::query();
    }

    public function index()
    {
        return $this->query()->get();
    }

    public function store($data)
    {
        $comment = Comment::create([
            'text' => $data['text'],
            'user_id' => Auth::id(),
            'blog_id' => $data['blog_id'],
            'reply_to' => $data['reply_to'] ?? null,
        ]);

        return $comment;
    }

    public function destroy($id)
    {

    }

    public function update(Comment $comment)
    {

    }
}

